<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\AnimalHealth;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AnimalHealthController extends Controller
{
    public function index(Request $request): View
    {
        $sortableColumns = [
            'animal' => 'animals.animal_id',
            'checkup' => 'animal_health.checkup_date',
            'condition' => 'animal_health.disease',
            'follow_up' => 'animal_health.next_checkup_date',
            'status' => 'animal_health.health_status',
        ];
        $statuses = ['Healthy', 'Sick', 'Under Treatment', 'Recovered'];
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', Rule::in($statuses)],
            'sort' => ['nullable', Rule::in(array_keys($sortableColumns))],
            'direction' => ['nullable', Rule::in(['asc', 'desc'])],
        ]);
        $search = $validated['search'] ?? '';
        $status = $validated['status'] ?? '';
        $sort = $validated['sort'] ?? 'checkup';
        $direction = $validated['direction'] ?? 'desc';

        $recordsQuery = AnimalHealth::query()
            ->with('animal')
            ->join('animals', 'animal_health.animal_id', '=', 'animals.id')
            ->select('animal_health.*');

        if ($search !== '') {
            $recordsQuery->where(function (Builder $query) use ($search): void {
                $query->whereHas('animal', fn (Builder $animalQuery) => $animalQuery
                    ->where('animal_id', 'like', "%{$search}%"))
                    ->orWhere('animal_health.health_status', 'like', "%{$search}%")
                    ->orWhere('animal_health.disease', 'like', "%{$search}%")
                    ->orWhere('animal_health.symptoms', 'like', "%{$search}%")
                    ->orWhere('animal_health.treatment', 'like', "%{$search}%")
                    ->orWhere('animal_health.medicine', 'like', "%{$search}%");
            });
        }

        if ($status !== '') {
            $recordsQuery->where('animal_health.health_status', $status);
        }

        $records = $recordsQuery
            ->orderBy($sortableColumns[$sort], $direction)
            ->orderByDesc('animal_health.id')
            ->paginate(10)
            ->withQueryString();

        $healthSummary = AnimalHealth::query()
            ->selectRaw('COUNT(*) AS total_records')
            ->selectRaw(
                'COALESCE(SUM(CASE WHEN health_status = ? THEN 1 ELSE 0 END), 0) AS sick_records',
                ['Sick']
            )
            ->selectRaw(
                'COALESCE(SUM(CASE WHEN health_status = ? THEN 1 ELSE 0 END), 0) AS treatment_records',
                ['Under Treatment']
            )
            ->selectRaw(
                'COALESCE(SUM(CASE WHEN next_checkup_date IS NOT NULL AND DATE(next_checkup_date) <= ? THEN 1 ELSE 0 END), 0) AS follow_ups_due',
                [today()->toDateString()]
            )
            ->first();

        return view('animal-health.index', compact(
            'records',
            'healthSummary',
            'search',
            'status',
            'statuses',
            'sort',
            'direction'
        ));
    }

    public function create()
    {
        $animals = Animal::orderBy('animal_id')->get();

        return view('animal-health.create', compact('animals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'animal_id' => [
                'required',
                'integer',
                Rule::exists('animals', 'id'),
            ],
            'checkup_date' => [
                'required',
                'date',
                'before_or_equal:today',
            ],
            'health_status' => [
                'required',
                Rule::in([
                    'Healthy',
                    'Sick',
                    'Under Treatment',
                    'Recovered',
                ]),
            ],
            'disease' => ['nullable', 'string', 'max:255'],
            'symptoms' => ['nullable', 'string', 'max:5000'],
            'treatment' => ['nullable', 'string', 'max:5000'],
            'medicine' => ['nullable', 'string', 'max:255'],
            'next_checkup_date' => [
                'nullable',
                'date',
                'after_or_equal:checkup_date',
            ],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        AnimalHealth::create($validated);

        return redirect()
            ->route('animal-health.index')
            ->with('success', 'Animal health record saved successfully.');
    }

    public function show(AnimalHealth $animalHealth)
    {
        $animalHealth->load('animal');

        return view('animal-health.show', compact('animalHealth'));
    }

    public function edit(AnimalHealth $animalHealth)
    {
        $animals = Animal::orderBy('animal_id')->get();

        return view('animal-health.edit', compact('animalHealth', 'animals'));
    }

    public function update(Request $request, AnimalHealth $animalHealth)
    {
        $validated = $request->validate([
            'animal_id' => [
                'required',
                'integer',
                Rule::exists('animals', 'id'),
            ],
            'checkup_date' => [
                'required',
                'date',
                'before_or_equal:today',
            ],
            'health_status' => [
                'required',
                Rule::in([
                    'Healthy',
                    'Sick',
                    'Under Treatment',
                    'Recovered',
                ]),
            ],
            'disease' => ['nullable', 'string', 'max:255'],
            'symptoms' => ['nullable', 'string', 'max:5000'],
            'treatment' => ['nullable', 'string', 'max:5000'],
            'medicine' => ['nullable', 'string', 'max:255'],
            'next_checkup_date' => [
                'nullable',
                'date',
                'after_or_equal:checkup_date',
            ],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $animalHealth->update($validated);

        return redirect()
            ->route('animal-health.index')
            ->with('success', 'Animal health record updated successfully.');
    }

    public function destroy(AnimalHealth $animalHealth)
    {
        $animalHealth->delete();

        return redirect()
            ->route('animal-health.index')
            ->with('success', 'Animal health record deleted successfully.');
    }
}
