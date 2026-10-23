<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\MilkProduction;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MilkProductionController extends Controller
{
    public function index(Request $request): View
    {
        $sortableColumns = [
            'date' => 'production_date',
            'animal_id' => 'animal_id',
            'morning' => 'morning_liters',
            'afternoon' => 'afternoon_liters',
            'evening' => 'evening_liters',
            'daily_total' => 'daily_total_liters',
        ];
        $validated = $request->validate([
            'date' => ['nullable', 'date', 'before_or_equal:today'],
            'search' => ['nullable', 'string', 'max:100'],
            'sort' => ['nullable', Rule::in(array_keys($sortableColumns))],
            'direction' => ['nullable', Rule::in(['asc', 'desc'])],
        ]);
        $selectedDate = $validated['date'] ?? today()->toDateString();
        $search = $validated['search'] ?? '';
        $sort = $validated['sort'] ?? 'date';
        $direction = $validated['direction'] ?? 'desc';

        $dailyProductionsQuery = MilkProduction::query()
            ->whereDate('production_date', $selectedDate);

        if ($search !== '') {
            $dailyProductionsQuery->whereHas('animal', function ($query) use ($search): void {
                $query->where('animal_id', 'like', "%{$search}%")
                    ->orWhere('breed', 'like', "%{$search}%");
            });
        }

        $dailyProductionsQuery
            ->select('production_date', 'animal_id')
            ->selectRaw('MIN(id) AS representative_id')
            ->selectRaw(
                'SUM(CASE WHEN session = ? THEN quantity_liters ELSE 0 END) AS morning_liters',
                ['Morning']
            )
            ->selectRaw(
                'SUM(CASE WHEN session = ? THEN quantity_liters ELSE 0 END) AS afternoon_liters',
                ['Afternoon']
            )
            ->selectRaw(
                'SUM(CASE WHEN session = ? THEN quantity_liters ELSE 0 END) AS evening_liters',
                ['Evening']
            )
            ->selectRaw('SUM(quantity_liters) AS daily_total_liters')
            ->selectRaw('COUNT(*) AS sessions_recorded')
            ->groupBy('production_date', 'animal_id')
            ->with('animal:id,animal_id,breed');

        $productions = $dailyProductionsQuery
            ->orderBy($sortableColumns[$sort], $direction)
            ->orderBy('animal_id')
            ->paginate(10)
            ->withQueryString();

        $todayTotal = MilkProduction::whereDate(
            'production_date',
            $selectedDate
        )->sum('quantity_liters');
        $activeDairyCows = Animal::query()
            ->where('animal_type', 'Dairy')
            ->where('status', 'Active')
            ->count();
        $averagePerCow = $activeDairyCows > 0
            ? (float) $todayTotal / $activeDairyCows
            : 0;
        $highestProduction = MilkProduction::query()
            ->whereDate('production_date', $selectedDate)
            ->select('animal_id')
            ->selectRaw('SUM(quantity_liters) AS daily_total_liters')
            ->groupBy('animal_id')
            ->orderByDesc('daily_total_liters')
            ->with('animal:id,animal_id')
            ->first();

        return view('milk-productions.index', compact(
            'productions',
            'todayTotal',
            'averagePerCow',
            'activeDairyCows',
            'highestProduction',
            'selectedDate',
            'search',
            'sort',
            'direction',
            'sortableColumns'
        ));
    }

    public function create()
    {
        $animals = Animal::where('animal_type', 'Dairy')
            ->where('status', 'Active')
            ->orderBy('animal_id')
            ->get();

        return view('milk-productions.create', compact('animals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'animal_id' => [
                'required',
                'integer',
                Rule::exists('animals', 'id')->where(
                    fn ($query) => $query
                        ->where('animal_type', 'Dairy')
                        ->where('status', 'Active')
                ),
            ],
            'production_date' => [
                'required',
                'date',
                'before_or_equal:today',
            ],
            'session' => [
                'required',
                Rule::in(['Morning', 'Afternoon', 'Evening']),
            ],
            'quantity_liters' => [
                'required',
                'numeric',
                'min:0.01',
                'max:999999.99',
            ],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        MilkProduction::create($validated);

        return redirect()
            ->route('milk-productions.index')
            ->with('success', 'Milk production recorded successfully.');
    }

    public function show(MilkProduction $milkProduction)
    {
        $milkProduction->load('animal');

        return view('milk-productions.show', compact('milkProduction'));
    }

    public function edit(MilkProduction $milkProduction)
    {
        $animals = Animal::where('animal_type', 'Dairy')
            ->where('status', 'Active')
            ->orderBy('animal_id')
            ->get();

        return view('milk-productions.edit', compact('milkProduction', 'animals'));
    }

    public function update(Request $request, MilkProduction $milkProduction)
    {
        $validated = $request->validate([
            'animal_id' => [
                'required',
                'integer',
                Rule::exists('animals', 'id')->where(
                    fn ($query) => $query
                        ->where('animal_type', 'Dairy')
                        ->where('status', 'Active')
                ),
            ],
            'production_date' => [
                'required',
                'date',
                'before_or_equal:today',
            ],
            'session' => [
                'required',
                Rule::in(['Morning', 'Afternoon', 'Evening']),
            ],
            'quantity_liters' => [
                'required',
                'numeric',
                'min:0.01',
                'max:999999.99',
            ],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $milkProduction->update($validated);

        return redirect()
            ->route('milk-productions.index')
            ->with('success', 'Milk production record updated successfully.');
    }

    public function destroy(MilkProduction $milkProduction)
    {
        $milkProduction->delete();

        return redirect()
            ->route('milk-productions.index')
            ->with('success', 'Milk production record deleted successfully.');
    }
}
