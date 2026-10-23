<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Sale;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SaleController extends Controller
{
    public function index(Request $request): View
    {
        $sortableColumns = [
            'sale_number' => 'sale_number',
            'date' => 'sale_date',
            'customer' => 'buyer_name',
            'product' => 'item_description',
            'quantity' => 'quantity',
            'unit_price' => 'unit_price',
            'total' => 'total_amount',
        ];
        $validated = $request->validate([
            'type' => ['nullable', Rule::in(['Milk', 'Animal'])],
            'search' => ['nullable', 'string', 'max:100'],
            'sort' => ['nullable', Rule::in(array_keys($sortableColumns))],
            'direction' => ['nullable', Rule::in(['asc', 'desc'])],
        ]);
        $type = $validated['type'] ?? 'Milk';
        $search = $validated['search'] ?? '';
        $sort = $validated['sort'] ?? 'date';
        $direction = $validated['direction'] ?? 'desc';

        $salesQuery = Sale::query()->with('animal:id,animal_id');
        $salesQuery->where('sale_type', $type);
        $monthlySalesQuery = Sale::query()
            ->where('sale_type', $type)
            ->whereBetween('sale_date', [
                now()->startOfMonth()->toDateString(),
                now()->endOfMonth()->toDateString(),
            ]);

        if ($search !== '') {
            $salesQuery->where(function ($query) use ($search): void {
                $query->where('sale_number', 'like', "%{$search}%")
                    ->orWhere('buyer_name', 'like', "%{$search}%")
                    ->orWhere('item_description', 'like', "%{$search}%")
                    ->orWhereHas('animal', fn ($animalQuery) => $animalQuery
                        ->where('animal_id', 'like', "%{$search}%"));
            });
        }

        $sales = $salesQuery
            ->orderBy($sortableColumns[$sort], $direction)
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();
        $monthlyRevenue = (float) $monthlySalesQuery->sum('total_amount');
        $monthlySalesCount = (int) (clone $monthlySalesQuery)->count();
        $averageSaleValue = $monthlySalesCount > 0
            ? $monthlyRevenue / $monthlySalesCount
            : 0;

        return view('sales.index', compact(
            'sales',
            'type',
            'search',
            'sort',
            'direction',
            'sortableColumns',
            'monthlyRevenue',
            'monthlySalesCount',
            'averageSaleValue'
        ));
    }

    public function create()
    {
        $animals = Animal::orderBy('animal_id')->get();

        return view('sales.create', compact('animals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sale_type' => [
                'required',
                Rule::in(['Animal', 'Milk']),
            ],

            'animal_id' => [
                'required',
                'integer',
                Rule::exists('animals', 'id')
                    ->when(
                        $request->input('sale_type') === 'Milk',
                        fn ($query) => $query->where('sex', 'Female')
                    ),
            ],

            'buyer_name' => [
                'required',
                'string',
                'max:255',
            ],

            'buyer_phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'item_description' => [
                'required',
                'string',
                'max:255',
            ],

            'quantity' => [
                'required',
                'numeric',
                'gt:0',
            ],

            'unit_price' => [
                'required',
                'numeric',
                'gte:0',
            ],

            'sale_date' => [
                'required',
                'date',
                'before_or_equal:today',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ], [
            'animal_id.required' => 'Please select an animal.',
            'animal_id.exists' => 'Milk sale can only be recorded for a female animal. Please select a female animal.',
        ]);

        $validated['sale_number'] = 'SAL-'
            .now()->format('YmdHis')
            .'-'
            .strtoupper(Str::random(4));

        $validated['total_amount'] = round(
            (float) $validated['quantity']
            * (float) $validated['unit_price'],
            2
        );

        Sale::create($validated);

        return redirect()
            ->route('sales.index')
            ->with('success', 'Sale recorded successfully.');
    }

    public function show(Sale $sale)
    {
        $sale->load('animal');

        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        $animals = Animal::orderBy('animal_id')->get();

        return view('sales.edit', compact('sale', 'animals'));
    }

    public function update(Request $request, Sale $sale)
    {
        $validated = $request->validate([
            'sale_type' => [
                'required',
                Rule::in(['Animal', 'Milk']),
            ],

            'animal_id' => [
                'required',
                'integer',
                Rule::exists('animals', 'id')
                    ->when(
                        $request->input('sale_type') === 'Milk',
                        fn ($query) => $query->where('sex', 'Female')
                    ),
            ],

            'buyer_name' => [
                'required',
                'string',
                'max:255',
            ],

            'buyer_phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'item_description' => [
                'required',
                'string',
                'max:255',
            ],

            'quantity' => [
                'required',
                'numeric',
                'gt:0',
            ],

            'unit_price' => [
                'required',
                'numeric',
                'gte:0',
            ],

            'sale_date' => [
                'required',
                'date',
                'before_or_equal:today',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ], [
            'animal_id.required' => 'Please select an animal.',
            'animal_id.exists' => 'Milk sale can only be recorded for a female animal. Please select a female animal.',
        ]);

        $validated['total_amount'] = round(
            (float) $validated['quantity']
            * (float) $validated['unit_price'],
            2
        );

        $sale->update($validated);

        return redirect()
            ->route('sales.index')
            ->with('success', 'Sale updated successfully.');
    }

    public function destroy(Sale $sale)
    {
        $sale->delete();

        return redirect()
            ->route('sales.index')
            ->with('success', 'Sale deleted successfully.');
    }
}
