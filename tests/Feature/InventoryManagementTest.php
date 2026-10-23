<?php

namespace Tests\Feature;

use App\Models\InventoryItem;
use App\Models\InventoryMovement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_inventory_page_calculates_stock_expiry_and_value_summaries(): void
    {
        $this->travelTo('2026-10-23 12:00:00');
        $user = User::factory()->create();
        $this->createItem('Oxytetracycline', 'Veterinary medicine', 'INV-101', 2, 3, 20, '2026-11-20');
        $this->createItem('Mineral supplements', 'Feed & nutrition', 'INV-102', 5, 2, 50, '2027-04-30');
        $this->createItem('Expired medicine', 'Veterinary medicine', 'INV-103', 1, 0, 10, '2026-10-22');

        $response = $this->actingAs($user)->get(route('inventory.index'));

        $response->assertOk();
        $response->assertSee('Inventory');
        $response->assertSee('3 matching items');
        $response->assertViewHas('inventorySummary', function ($summary): bool {
            return (int) $summary->total_items === 3
                && (int) $summary->low_stock_items === 1
                && (int) $summary->expiring_medicines === 1
                && (float) $summary->inventory_value === 300.0;
        });
    }

    public function test_inventory_search_and_stock_filter_show_matching_items(): void
    {
        $user = User::factory()->create();
        $this->createItem('Oxytetracycline', 'Veterinary medicine', 'INV-101', 2, 3);
        $this->createItem('Mineral supplements', 'Feed & nutrition', 'INV-102', 5, 2);
        $this->createItem('Empty container', 'Supplies', 'INV-103', 0, 0);

        $response = $this->actingAs($user)->get(route('inventory.index', [
            'search' => 'INV-',
            'stock' => 'low',
        ]));

        $response->assertOk();
        $response->assertSee('Oxytetracycline');
        $response->assertDontSee('Mineral supplements');
        $response->assertSee('Empty container');
        $response->assertSee('2 matching items');
    }

    public function test_expiring_and_expired_filters_use_the_expiry_date_boundary(): void
    {
        $this->travelTo('2026-10-23 12:00:00');
        $user = User::factory()->create();
        $this->createItem('Expires soon', 'Veterinary medicine', 'INV-111', 2, 1, 10, '2027-01-21');
        $this->createItem('Already expired', 'Veterinary medicine', 'INV-112', 2, 1, 10, '2026-10-22');
        $this->createItem('Expires later', 'Feed', 'INV-113', 2, 1, 10, '2027-01-22');

        $expiringResponse = $this->actingAs($user)->get(route('inventory.index', [
            'stock' => 'expiring',
        ]));

        $expiringResponse->assertOk();
        $expiringResponse->assertSee('Expires soon');
        $expiringResponse->assertDontSee('Already expired');
        $expiringResponse->assertDontSee('Expires later');

        $expiredResponse = $this->get(route('inventory.index', [
            'stock' => 'expired',
        ]));

        $expiredResponse->assertOk();
        $expiredResponse->assertSee('Already expired');
        $expiredResponse->assertDontSee('Expires soon');
    }

    public function test_inventory_items_can_be_sorted_by_quantity(): void
    {
        $user = User::factory()->create();
        $this->createItem('Higher stock', 'Feed', 'INV-101', 8, 2);
        $this->createItem('Lower stock', 'Feed', 'INV-102', 2, 1);

        $response = $this->actingAs($user)->get(route('inventory.index', [
            'sort' => 'quantity',
            'direction' => 'asc',
        ]));

        $response->assertOk();
        $response->assertViewHas('items', function ($items): bool {
            return $items->getCollection()
                ->pluck('name')
                ->all() === ['Lower stock', 'Higher stock'];
        });
    }

    public function test_invalid_inventory_sort_filter_and_stock_filter_are_rejected(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('inventory.index', ['sort' => 'quantity;drop table inventory_items']))
            ->assertRedirect()
            ->assertSessionHasErrors('sort');

        $this->actingAs($user)
            ->get(route('inventory.index', ['stock' => 'unexpected']))
            ->assertRedirect()
            ->assertSessionHasErrors('stock');
    }

    public function test_creating_an_item_records_initial_stock_and_escapes_its_name(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('inventory.store'), [
            'name' => '<script>alert(1)</script>',
            'category' => 'Veterinary medicine',
            'sku' => 'INV-201',
            'initial_quantity' => '8',
            'unit' => 'vials',
            'reorder_level' => '12',
            'expiry_date' => '2027-02-28',
            'supplier' => 'Regional veterinary supplier',
            'unit_cost' => '125.50',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $item = InventoryItem::query()->where('sku', 'INV-201')->firstOrFail();
        $this->assertModelExists($item);
        $this->assertSame('8.00', $item->quantity);
        $this->assertDatabaseHas('inventory_movements', [
            'inventory_item_id' => $item->id,
            'user_id' => $user->id,
            'movement_type' => 'in',
            'quantity' => '8.00',
            'quantity_before' => '0.00',
            'quantity_after' => '8.00',
            'reason' => 'Initial stock',
        ]);

        $showResponse = $this->get(route('inventory.show', $item));
        $showResponse->assertOk();
        $showResponse->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false);
        $showResponse->assertDontSee('<script>alert(1)</script>', false);
    }

    public function test_duplicate_inventory_sku_is_rejected(): void
    {
        $user = User::factory()->create();
        $this->createItem('First item', 'Supplies', 'INV-201', 1, 1);

        $response = $this->actingAs($user)->from(route('inventory.create'))->post(route('inventory.store'), [
            'name' => 'Duplicate item',
            'category' => 'Supplies',
            'sku' => 'INV-201',
            'initial_quantity' => '1',
            'unit' => 'pieces',
            'reorder_level' => '1',
            'unit_cost' => '20',
        ]);

        $response->assertRedirect(route('inventory.create'));
        $response->assertSessionHasErrors('sku');
        $this->assertDatabaseCount('inventory_items', 1);
    }

    public function test_editing_item_details_does_not_change_the_stock_balance(): void
    {
        $user = User::factory()->create();
        $item = $this->createItem('Old name', 'Supplies', 'INV-301', 4, 2);

        $response = $this->actingAs($user)->put(route('inventory.update', $item), [
            'name' => 'Updated name',
            'category' => 'Equipment',
            'sku' => 'INV-301',
            'unit' => 'pieces',
            'reorder_level' => '3',
            'expiry_date' => '',
            'supplier' => 'Farm supplier',
            'unit_cost' => '75.50',
        ]);

        $response->assertRedirect(route('inventory.show', $item));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('inventory_items', [
            'id' => $item->id,
            'name' => 'Updated name',
            'quantity' => '4.00',
            'unit_cost' => '75.50',
        ]);
        $this->assertDatabaseCount('inventory_movements', 0);
    }

    public function test_stock_in_updates_the_balance_and_creates_a_movement_record(): void
    {
        $user = User::factory()->create();
        $item = $this->createItem('Mineral supplements', 'Feed', 'INV-401', 6, 2);

        $response = $this->actingAs($user)->post(route('inventory.movements.store', $item), [
            'movement_type' => 'in',
            'quantity' => '4.5',
            'reason' => 'Supplier delivery',
        ]);

        $response->assertRedirect(route('inventory.show', $item));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('inventory_items', [
            'id' => $item->id,
            'quantity' => '10.50',
        ]);
        $this->assertDatabaseHas('inventory_movements', [
            'inventory_item_id' => $item->id,
            'user_id' => $user->id,
            'movement_type' => 'in',
            'quantity' => '4.50',
            'quantity_before' => '6.00',
            'quantity_after' => '10.50',
            'reason' => 'Supplier delivery',
        ]);

        $historyResponse = $this->get(route('inventory-movements.index'));
        $historyResponse->assertOk();
        $historyResponse->assertSee('Supplier delivery');
        $historyResponse->assertSee('Mineral supplements');
    }

    public function test_item_unit_cannot_change_after_stock_movements_are_recorded(): void
    {
        $user = User::factory()->create();
        $item = $this->createItem('Mineral supplements', 'Feed', 'INV-302', 4, 2);
        InventoryMovement::create([
            'inventory_item_id' => $item->id,
            'user_id' => $user->id,
            'movement_type' => 'in',
            'quantity' => '4.00',
            'quantity_before' => '0.00',
            'quantity_after' => '4.00',
            'reason' => 'Initial stock',
        ]);

        $response = $this->actingAs($user)->from(route('inventory.edit', $item))
            ->put(route('inventory.update', $item), [
                'name' => 'Mineral supplements',
                'category' => 'Feed',
                'sku' => 'INV-302',
                'unit' => 'bags',
                'reorder_level' => '2',
                'unit_cost' => '0',
            ]);

        $response->assertRedirect(route('inventory.edit', $item));
        $response->assertSessionHasErrors('unit');
        $this->assertDatabaseHas('inventory_items', [
            'id' => $item->id,
            'unit' => 'units',
            'quantity' => '4.00',
        ]);
    }

    public function test_stock_out_updates_balance_and_rejects_withdrawals_above_available_stock(): void
    {
        $user = User::factory()->create();
        $item = $this->createItem('Mineral supplements', 'Feed', 'INV-402', 6, 2);

        $validResponse = $this->actingAs($user)->post(route('inventory.movements.store', $item), [
            'movement_type' => 'out',
            'quantity' => '2.25',
            'reason' => 'Daily feed allocation',
        ]);

        $validResponse->assertRedirect(route('inventory.show', $item));
        $this->assertDatabaseHas('inventory_items', [
            'id' => $item->id,
            'quantity' => '3.75',
        ]);
        $this->assertDatabaseHas('inventory_movements', [
            'inventory_item_id' => $item->id,
            'movement_type' => 'out',
            'quantity' => '2.25',
            'quantity_before' => '6.00',
            'quantity_after' => '3.75',
        ]);

        $invalidResponse = $this->actingAs($user)->from(route('inventory.movements.create', $item))
            ->post(route('inventory.movements.store', $item), [
                'movement_type' => 'out',
                'quantity' => '4',
                'reason' => 'Excess withdrawal',
            ]);

        $invalidResponse->assertRedirect(route('inventory.movements.create', $item));
        $invalidResponse->assertSessionHasErrors('quantity');
        $this->assertDatabaseHas('inventory_items', [
            'id' => $item->id,
            'quantity' => '3.75',
        ]);
        $this->assertDatabaseCount('inventory_movements', 1);
    }

    public function test_inventory_pages_redirect_unauthenticated_users_to_login(): void
    {
        $item = $this->createItem('Mineral supplements', 'Feed', 'INV-501', 6, 2);

        $response = $this->get(route('inventory.index'));

        $response->assertRedirect(route('login'));
        $this->get(route('inventory.show', $item))->assertRedirect(route('login'));
        $this->get(route('inventory-movements.index'))->assertRedirect(route('login'));
    }

    private function createItem(
        string $name,
        string $category,
        string $sku,
        float $quantity,
        float $reorderLevel,
        float $unitCost = 0,
        ?string $expiryDate = null
    ): InventoryItem {
        return InventoryItem::create([
            'name' => $name,
            'category' => $category,
            'sku' => $sku,
            'quantity' => $quantity,
            'unit' => 'units',
            'reorder_level' => $reorderLevel,
            'expiry_date' => $expiryDate,
            'unit_cost' => $unitCost,
        ]);
    }
}
