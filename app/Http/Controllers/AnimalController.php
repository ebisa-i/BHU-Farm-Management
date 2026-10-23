<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\AnimalHealth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AnimalController extends Controller
{
    public function index(Request $request): View
    {
        $sortableColumns = [
            'animal_id' => 'animal_id',
            'type' => 'animal_type',
            'breed' => 'breed',
            'sex' => 'sex',
            'born' => 'date_of_birth',
            'weight' => 'weight',
            'status' => 'status',
            'registered' => 'created_at',
            'health_check' => 'health_check',
        ];
        $search = $request->query('search', '');
        $sort = $request->query('sort', 'registered');
        $direction = $request->query('direction', 'desc');

        abort_unless(
            is_string($search) && mb_strlen($search) <= 100,
            422,
            'The animal search query must be a string of at most 100 characters.'
        );
        abort_unless(
            is_string($sort) && array_key_exists($sort, $sortableColumns),
            422,
            'The selected animal sort column is invalid.'
        );
        abort_unless(
            is_string($direction) && in_array($direction, ['asc', 'desc'], true),
            422,
            'The selected sort direction is invalid.'
        );

        $animalsQuery = Animal::query();

        if ($search !== '') {
            $animalsQuery->where(function ($query) use ($search): void {
                $query->where('animal_id', 'like', "%{$search}%")
                    ->orWhere('animal_type', 'like', "%{$search}%")
                    ->orWhere('breed', 'like', "%{$search}%")
                    ->orWhere('sex', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            });
        }

        $animalsQuery->withMax('healthRecords', 'checkup_date');

        if ($sort === 'health_check') {
            $animalsQuery->orderBy(
                AnimalHealth::query()
                    ->select('checkup_date')
                    ->whereColumn('animal_health.animal_id', 'animals.id')
                    ->latest('checkup_date')
                    ->limit(1),
                $direction
            );
        } else {
            $animalsQuery->orderBy($sortableColumns[$sort], $direction);
        }

        $animals = $animalsQuery
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        $animalSummary = Animal::query()
            ->selectRaw('COUNT(*) AS total_animals')
            ->selectRaw(
                'COALESCE(SUM(CASE WHEN status = ? THEN 1 ELSE 0 END), 0) AS active_animals',
                ['Active']
            )
            ->selectRaw(
                'COALESCE(SUM(CASE WHEN animal_type = ? THEN 1 ELSE 0 END), 0) AS dairy_animals',
                ['Dairy']
            )
            ->selectRaw(
                'COALESCE(SUM(CASE WHEN animal_type = ? THEN 1 ELSE 0 END), 0) AS beef_animals',
                ['Beef']
            )
            ->selectRaw(
                'COALESCE(SUM(CASE WHEN animal_type = ? THEN 1 ELSE 0 END), 0) AS calves',
                ['Calf']
            )
            ->first();

        $dueHealthReviews = AnimalHealth::query()
            ->whereNotNull('next_checkup_date')
            ->whereDate('next_checkup_date', '<=', today())
            ->distinct()
            ->count('animal_id');

        return view('animals.index', compact(
            'animals',
            'animalSummary',
            'dueHealthReviews',
            'search',
            'sort',
            'direction',
            'sortableColumns'
        ));
    }

    public function show(Animal $animal): View
    {
        $latestHealthRecord = $animal->healthRecords()
            ->latest('checkup_date')
            ->first();

        return view('animals.show', compact('animal', 'latestHealthRecord'));
    }

    public function create()
    {
        return view('animals.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'animal_type' => ['required', Rule::in(['Dairy', 'Beef', 'Calf'])],
            'breed' => ['nullable', 'string', 'max:255'],
            'sex' => ['required', Rule::in(['Male', 'Female'])],
            'date_of_birth' => ['nullable', 'date', 'before_or_equal:today'],
            'weight' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'status' => ['required', Rule::in(['Active', 'Sold', 'Deceased', 'Transferred'])],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $prefix = match ($validated['animal_type']) {
            'Dairy' => 'D',
            'Beef' => 'B',
            'Calf' => 'C',
        };

        $year = now()->year;

        $lastAnimal = Animal::where('animal_id', 'like', "{$prefix}-{$year}-%")
            ->orderByDesc('id')
            ->first();

        $sequence = $lastAnimal
            ? ((int) substr($lastAnimal->animal_id, -3)) + 1
            : 1;

        $validated['animal_id'] = sprintf(
            '%s-%s-%03d',
            $prefix,
            $year,
            $sequence
        );

        Animal::create($validated);

        return redirect()->route('animals.index')
            ->with('success', 'Animal registered successfully.');
    }

    public function edit(Animal $animal)
    {
        return view('animals.edit', compact('animal'));
    }

    public function update(Request $request, Animal $animal)
    {
        $validated = $request->validate([
            'animal_type' => ['required', Rule::in(['Dairy', 'Beef', 'Calf'])],
            'breed' => ['nullable', 'string', 'max:255'],
            'sex' => ['required', Rule::in(['Male', 'Female'])],
            'date_of_birth' => ['nullable', 'date', 'before_or_equal:today'],
            'weight' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'status' => ['required', Rule::in(['Active', 'Sold', 'Deceased', 'Transferred'])],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        unset($validated['animal_id']);

        $animal->update($validated);

        return redirect()->route('animals.index')
            ->with('success', 'Animal updated successfully.');
    }

    public function destroy(Animal $animal)
    {
        $animal->delete();

        return redirect()->route('animals.index')
            ->with('success', 'Animal deleted successfully.');
    }
}
