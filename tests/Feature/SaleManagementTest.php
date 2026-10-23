<?php

namespace Tests\Feature;

use App\Models\Animal;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SaleManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_sales_page_shows_selected_sale_type_and_monthly_summary(): void
    {
        $this->travelTo('2026-10-23 12:00:00');
        $user = User::factory()->create();
        $dairyCow = $this->createAnimal('D-2026-001');

        $this->createSale($dairyCow, 'SAL-001', 'Milk', 'October milk', 'Dairy Co-op', 100, 100, '2026-10-10');
        $this->createSale($dairyCow, 'SAL-002', 'Milk', 'September milk', 'Town Market', 50, 50, '2026-09-10');
        $this->createSale($dairyCow, 'SAL-003', 'Animal', 'Cattle sale', 'Farm Buyer', 1, 30000, '2026-10-12');

        $response = $this->actingAs($user)->get(route('sales.index', ['type' => 'Milk']));

        $response->assertOk();
        $response->assertViewHas('monthlyRevenue', 10000.0);
        $response->assertViewHas('monthlySalesCount', 1);
        $response->assertViewHas('averageSaleValue', 10000.0);
        $response->assertSee('Milk Sales');
        $response->assertSee('2 matching records');
        $response->assertSee('October milk');
        $response->assertSee('September milk');
        $response->assertDontSee('Cattle sale');
    }

    public function test_sales_search_filters_records_without_changing_monthly_summary(): void
    {
        $this->travelTo('2026-10-23 12:00:00');
        $user = User::factory()->create();
        $dairyCow = $this->createAnimal('D-2026-001');
        $this->createSale($dairyCow, 'SAL-001', 'Milk', 'Fresh milk', 'Dairy Co-op', 100, 100, '2026-10-10');
        $this->createSale($dairyCow, 'SAL-002', 'Milk', 'Yogurt', 'Town Market', 20, 60, '2026-10-11');

        $response = $this->actingAs($user)->get(route('sales.index', [
            'type' => 'Milk',
            'search' => 'Dairy Co-op',
        ]));

        $response->assertOk();
        $response->assertSee('SAL-001');
        $response->assertDontSee('SAL-002');
        $response->assertSee('1 matching record');
        $response->assertViewHas('monthlyRevenue', 11200.0);
    }

    public function test_sales_can_be_sorted_by_total_amount(): void
    {
        $user = User::factory()->create();
        $dairyCow = $this->createAnimal('D-2026-001');
        $this->createSale($dairyCow, 'SAL-002', 'Milk', 'Large order', 'Customer B', 20, 100, '2026-10-11');
        $this->createSale($dairyCow, 'SAL-001', 'Milk', 'Small order', 'Customer A', 10, 50, '2026-10-10');

        $response = $this->actingAs($user)->get(route('sales.index', [
            'type' => 'Milk',
            'sort' => 'total',
            'direction' => 'asc',
        ]));

        $response->assertOk();
        $response->assertViewHas('sales', function ($sales): bool {
            return $sales->getCollection()
                ->pluck('sale_number')
                ->all() === ['SAL-001', 'SAL-002'];
        });
    }

    public function test_invalid_sale_type_is_rejected(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('sales.index', ['type' => 'Invalid']));

        $response->assertRedirect();
        $response->assertSessionHasErrors('type');
    }

    private function createAnimal(string $animalId): Animal
    {
        return Animal::create([
            'animal_id' => $animalId,
            'animal_type' => 'Dairy',
            'breed' => 'Holstein',
            'sex' => 'Female',
            'date_of_birth' => '2022-03-18',
            'weight' => 465,
            'status' => 'Active',
        ]);
    }

    private function createSale(
        Animal $animal,
        string $saleNumber,
        string $type,
        string $description,
        string $buyer,
        float $quantity,
        float $unitPrice,
        string $saleDate
    ): Sale {
        return Sale::create([
            'sale_number' => $saleNumber,
            'sale_type' => $type,
            'animal_id' => $animal->id,
            'buyer_name' => $buyer,
            'item_description' => $description,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_amount' => $quantity * $unitPrice,
            'sale_date' => $saleDate,
        ]);
    }
}
