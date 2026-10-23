<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\InventoryMovement;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class InventoryController extends Controller
{
    private const SORTABLE_COLUMNS = [
        'name' => 'name',
        'category' => 'category',
        'sku' => 'sku',
        'quantity' => 'quantity',
        'reorder_level' => 'reorder_level',
        'expiry_date' => 'expiry_date',
        'supplier' => 'supplier',
    ];

    private const STOCK_FILTERS = [
        'all',
        'low',
        'out',
        'expiring',
        'expired',
    ];

    public function index(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'stock' => ['nullable', Rule::in(self::STOCK_FILTERS)],
            'sort' => ['nullable', Rule::in(array_keys(self::SORTABLE_COLUMNS))],
            'direction' => ['nullable', Rule::in(['asc', 'desc'])],
        ]);
        $search = $validated['search'] ?? '';
        $stock = $validated['stock'] ?? 'all';
        $sort = $validated['sort'] ?? 'name';
        $direction = $validated['direction'] ?? 'asc';

        $itemsQuery = InventoryItem::query();

        if ($search !== '') {
            $itemsQuery->where(function (Builder $query) use ($search): void {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('supplier', 'like', "%{$search}%");
            });
        }

        match ($stock) {
            'low' => $itemsQuery->whereColumn('quantity', '<=', 'reorder_level'),
            'out' => $itemsQuery->where('quantity', 0),
            'expiring' => $this->applyExpiringFilter($itemsQuery),
            'expired' => $itemsQuery->whereNotNull('expiry_date')
                ->whereDate('expiry_date', '<', today()),
            default => null,
        };

        $items = $itemsQuery
            ->orderBy(self::SORTABLE_COLUMNS[$sort], $direction)
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        $inventorySummary = InventoryItem::query()
            ->selectRaw('COUNT(*) AS total_items')
            ->selectRaw(
                'COALESCE(SUM(CASE WHEN quantity <= reorder_level THEN 1 ELSE 0 END), 0) AS low_stock_items'
            )
            ->selectRaw('COALESCE(SUM(quantity * unit_cost), 0) AS inventory_value')
            ->first();

        $inventorySummary->expiring_medicines = InventoryItem::query()
            ->whereRaw('LOWER(category) LIKE ?', ['%medic%'])
            ->whereNotNull('expiry_date')
            ->whereDate('expiry_date', '>=', today())
            ->whereDate('expiry_date', '<=', today()->addDays(90))
            ->count();

        $lowStockNames = InventoryItem::query()
            ->whereColumn('quantity', '<=', 'reorder_level')
            ->orderBy('quantity')
            ->limit(3)
            ->pluck('name');

        return view('inventory.index', compact(
            'items',
            'inventorySummary',
            'lowStockNames',
            'search',
            'stock',
            'sort',
            'direction'
        ));
    }

    public function create(): View
    {
        return view('inventory.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'sku' => ['required', 'string', 'max:100', Rule::unique('inventory_items', 'sku')],
            'initial_quantity' => ['required', 'numeric', 'gte:0', 'decimal:0,2'],
            'unit' => ['required', 'string', 'max:50'],
            'reorder_level' => ['required', 'numeric', 'gte:0', 'decimal:0,2'],
            'expiry_date' => ['nullable', 'date'],
            'supplier' => ['nullable', 'string', 'max:255'],
            'unit_cost' => ['required', 'numeric', 'gte:0', 'decimal:0,2'],
        ]);

        $item = DB::transaction(function () use ($validated, $request): InventoryItem {
            $initialQuantity = $validated['initial_quantity'];
            unset($validated['initial_quantity']);
            $validated['quantity'] = $initialQuantity;
            $item = InventoryItem::create($validated);

            if ((float) $initialQuantity > 0) {
                InventoryMovement::create([
                    'inventory_item_id' => $item->id,
                    'user_id' => $request->user()->id,
                    'movement_type' => 'in',
                    'quantity' => $initialQuantity,
                    'quantity_before' => 0,
                    'quantity_after' => $initialQuantity,
                    'reason' => 'Initial stock',
                ]);
            }

            return $item;
        });

        return redirect()
            ->route('inventory.show', $item)
            ->with('success', 'Inventory item created successfully.');
    }

    public function show(InventoryItem $inventoryItem): View
    {
        $movements = $inventoryItem->movements()
            ->with('user:id,name')
            ->latest()
            ->latest('id')
            ->paginate(10);

        return view('inventory.show', compact('inventoryItem', 'movements'));
    }

    public function edit(InventoryItem $inventoryItem): View
    {
        $unitLocked = $inventoryItem->movements()->exists();

        return view('inventory.edit', compact('inventoryItem', 'unitLocked'));
    }

    public function update(Request $request, InventoryItem $inventoryItem): RedirectResponse
    {
        $unitRules = ['required', 'string', 'max:50'];
        if ($inventoryItem->movements()->exists()) {
            $unitRules[] = Rule::in([$inventoryItem->unit]);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'sku' => [
                'required',
                'string',
                'max:100',
                Rule::unique('inventory_items', 'sku')->ignore($inventoryItem->id),
            ],
            'unit' => $unitRules,
            'reorder_level' => ['required', 'numeric', 'gte:0', 'decimal:0,2'],
            'expiry_date' => ['nullable', 'date'],
            'supplier' => ['nullable', 'string', 'max:255'],
            'unit_cost' => ['required', 'numeric', 'gte:0', 'decimal:0,2'],
        ]);

        $inventoryItem->update($validated);

        return redirect()
            ->route('inventory.show', $inventoryItem)
            ->with('success', 'Inventory item updated successfully.');
    }

    private function applyExpiringFilter(Builder $query): void
    {
        $query->whereNotNull('expiry_date')
            ->whereDate('expiry_date', '>=', today())
            ->whereDate('expiry_date', '<=', today()->addDays(90));
    }
}
