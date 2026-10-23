<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Breeding;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BreedingController extends Controller
{
    public function index(Request $request): View
    {
        $sortableColumns = [
            'record' => 'id',
            'animal_id' => 'female_animal_id',
            'service_date' => 'mating_date',
            'method' => 'breeding_method',
            'expected_calving' => 'expected_calving_date',
            'result' => 'status',
        ];
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'sort' => ['nullable', Rule::in(array_keys($sortableColumns))],
            'direction' => ['nullable', Rule::in(['asc', 'desc'])],
        ]);
        $search = $validated['search'] ?? '';
        $sort = $validated['sort'] ?? 'service_date';
        $direction = $validated['direction'] ?? 'desc';

        $breedingsQuery = Breeding::query()->with([
            'femaleAnimal:id,animal_id',
            'maleAnimal:id,animal_id',
        ]);

        if ($search !== '') {
            $breedingsQuery->where(function ($query) use ($search): void {
                $query->where('status', 'like', "%{$search}%")
                    ->orWhere('breeding_method', 'like', "%{$search}%")
                    ->orWhereHas('femaleAnimal', fn ($animalQuery) => $animalQuery
                        ->where('animal_id', 'like', "%{$search}%"))
                    ->orWhereHas('maleAnimal', fn ($animalQuery) => $animalQuery
                        ->where('animal_id', 'like', "%{$search}%"));
            });
        }

        $breedings = $breedingsQuery
            ->orderBy($sortableColumns[$sort], $direction)
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        $breedingSummary = Breeding::query()
            ->selectRaw(
                'COALESCE(SUM(CASE WHEN status = ? THEN 1 ELSE 0 END), 0) AS pregnant_cows',
                ['Pregnant']
            )
            ->selectRaw(
                'COALESCE(SUM(CASE WHEN status IN (?, ?) AND expected_calving_date BETWEEN ? AND ? THEN 1 ELSE 0 END), 0) AS due_within_30_days',
                [
                    'Pregnant',
                    'Pending',
                    today()->toDateString(),
                    today()->addDays(30)->toDateString(),
                ]
            )
            ->selectRaw(
                'COALESCE(SUM(CASE WHEN breeding_method = ? AND mating_date BETWEEN ? AND ? THEN 1 ELSE 0 END), 0) AS inseminations_this_month',
                [
                    'Artificial Insemination',
                    now()->startOfMonth()->toDateString(),
                    now()->endOfMonth()->toDateString(),
                ]
            )
            ->selectRaw(
                'COALESCE(SUM(CASE WHEN actual_calving_date BETWEEN ? AND ? THEN 1 ELSE 0 END), 0) AS calves_born_this_year',
                [
                    now()->startOfYear()->toDateString(),
                    now()->endOfYear()->toDateString(),
                ]
            )
            ->first();

        return view('breedings.index', compact(
            'breedings',
            'breedingSummary',
            'search',
            'sort',
            'direction'
        ));
    }

    public function create()
    {
        $females = Animal::where('sex', 'Female')
            ->where('status', 'Active')
            ->orderBy('animal_id')
            ->get();

        $males = Animal::where('sex', 'Male')
            ->where('status', 'Active')
            ->orderBy('animal_id')
            ->get();

        return view('breedings.create', compact('females', 'males'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'female_animal_id' => [
                'required',
                'integer',
                Rule::exists('animals', 'id')
                    ->where(fn ($query) => $query
                        ->where('sex', 'Female')
                        ->where('status', 'Active')),
            ],

            'male_animal_id' => [
                'nullable',
                'integer',
                Rule::exists('animals', 'id')
                    ->where(fn ($query) => $query
                        ->where('sex', 'Male')
                        ->where('status', 'Active')),
            ],

            'mating_date' => [
                'required',
                'date',
                'before_or_equal:today',
            ],

            'expected_calving_date' => [
                'nullable',
                'date',
                'after:mating_date',
            ],

            'actual_calving_date' => [
                'nullable',
                'date',
                'after_or_equal:mating_date',
                'before_or_equal:today',
            ],

            'breeding_method' => [
                'required',
                Rule::in(['Natural', 'Artificial Insemination']),
            ],

            'status' => [
                'required',
                Rule::in([
                    'Pending',
                    'Pregnant',
                    'Calved',
                    'Failed',
                ]),
            ],

            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        Breeding::create($validated);

        return redirect()
            ->route('breedings.index')
            ->with('success', 'Breeding record saved successfully.');
    }

    public function show(Breeding $breeding)
    {
        $breeding->load(['femaleAnimal', 'maleAnimal']);

        return view('breedings.show', compact('breeding'));
    }

    public function edit(Breeding $breeding)
    {
        $females = Animal::where('sex', 'Female')
            ->where('status', 'Active')
            ->orderBy('animal_id')
            ->get();

        $males = Animal::where('sex', 'Male')
            ->where('status', 'Active')
            ->orderBy('animal_id')
            ->get();

        return view('breedings.edit', compact('breeding', 'females', 'males'));
    }

    public function update(Request $request, Breeding $breeding)
    {
        $validated = $request->validate([
            'female_animal_id' => [
                'required',
                'integer',
                Rule::exists('animals', 'id')
                    ->where(fn ($query) => $query
                        ->where('sex', 'Female')
                        ->where('status', 'Active')),
            ],

            'male_animal_id' => [
                'nullable',
                'integer',
                Rule::exists('animals', 'id')
                    ->where(fn ($query) => $query
                        ->where('sex', 'Male')
                        ->where('status', 'Active')),
            ],

            'mating_date' => [
                'required',
                'date',
                'before_or_equal:today',
            ],

            'expected_calving_date' => [
                'nullable',
                'date',
                'after:mating_date',
            ],

            'actual_calving_date' => [
                'nullable',
                'date',
                'after_or_equal:mating_date',
                'before_or_equal:today',
            ],

            'breeding_method' => [
                'required',
                Rule::in(['Natural', 'Artificial Insemination']),
            ],

            'status' => [
                'required',
                Rule::in([
                    'Pending',
                    'Pregnant',
                    'Calved',
                    'Failed',
                ]),
            ],

            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $breeding->update($validated);

        return redirect()
            ->route('breedings.index')
            ->with('success', 'Breeding record updated successfully.');
    }

    public function destroy(Breeding $breeding)
    {
        $breeding->delete();

        return redirect()
            ->route('breedings.index')
            ->with('success', 'Breeding record deleted successfully.');
    }
}
