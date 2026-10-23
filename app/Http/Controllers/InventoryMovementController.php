<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\InventoryMovement;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InventoryMovementController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'item' => ['nullable', 'integer', 'exists:inventory_items,id'],
        ]);
        $movementsQuery = InventoryMovement::query()
            ->with([
                'inventoryItem:id,name,sku,unit',
                'user:id,name',
            ]);

        if (isset($validated['item'])) {
            $movementsQuery->where('inventory_item_id', $validated['item']);
        }

        $movements = $movementsQuery
            ->latest()
            ->latest('id')
            ->paginate(15)
            ->withQueryString();
        $selectedItem = isset($validated['item'])
            ? InventoryItem::findOrFail($validated['item'])
            : null;

        return view('inventory-movements.index', compact('movements', 'selectedItem'));
    }

    public function create(InventoryItem $inventoryItem): View
    {
        return view('inventory-movements.create', compact('inventoryItem'));
    }

    public function store(Request $request, InventoryItem $inventoryItem): RedirectResponse
    {
        $validated = $request->validate([
            'movement_type' => ['required', 'in:in,out'],
            'quantity' => ['required', 'numeric', 'gt:0', 'decimal:0,2'],
            'reason' => ['required', 'string', 'max:500'],
        ]);

        DB::transaction(function () use ($validated, $inventoryItem, $request): void {
            $lockedItem = InventoryItem::query()
                ->lockForUpdate()
                ->findOrFail($inventoryItem->id);
            $quantityBefore = (float) $lockedItem->quantity;
            $quantityMoved = (float) $validated['quantity'];
            $quantityAfter = $validated['movement_type'] === 'in'
                ? $quantityBefore + $quantityMoved
                : $quantityBefore - $quantityMoved;

            if ($quantityAfter < 0) {
                throw ValidationException::withMessages([
                    'quantity' => 'The stock-out quantity cannot exceed the available stock.',
                ]);
            }

            $quantityAfter = round($quantityAfter, 2);
            $lockedItem->update([
                'quantity' => number_format($quantityAfter, 2, '.', ''),
            ]);

            InventoryMovement::create([
                'inventory_item_id' => $lockedItem->id,
                'user_id' => $request->user()->id,
                'movement_type' => $validated['movement_type'],
                'quantity' => number_format($quantityMoved, 2, '.', ''),
                'quantity_before' => number_format($quantityBefore, 2, '.', ''),
                'quantity_after' => number_format($quantityAfter, 2, '.', ''),
                'reason' => $validated['reason'],
            ]);
        });

        return redirect()
            ->route('inventory.show', $inventoryItem)
            ->with('success', 'Stock movement recorded successfully.');
    }
}
