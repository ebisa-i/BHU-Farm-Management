<?php

namespace Tests\Feature;

use App\Models\Animal;
use App\Models\MilkProduction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MilkProductionManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_milk_production_page_shows_daily_totals_and_cow_summary(): void
    {
        $user = User::factory()->create();
        $firstCow = $this->createDairyCow('D-2026-001', 'Holstein');
        $secondCow = $this->createDairyCow('D-2026-002', 'Jersey');
        $this->createDairyCow('D-2026-003', 'Boran');

        $this->createProduction($firstCow, '2026-10-21', 'Morning', 12.5);
        $this->createProduction($firstCow, '2026-10-21', 'Evening', 9.2);
        $this->createProduction($secondCow, '2026-10-21', 'Morning', 8.3);
        $this->createProduction($firstCow, '2026-10-20', 'Morning', 30);

        $response = $this->actingAs($user)->get(route('milk-productions.index', [
            'date' => '2026-10-21',
        ]));

        $response->assertOk();
        $response->assertViewHas('todayTotal', 30.0);
        $response->assertViewHas('averagePerCow', 10.0);
        $response->assertViewHas('activeDairyCows', 3);
        $response->assertViewHas('highestProduction', function (MilkProduction $production): bool {
            return $production->animal->animal_id === 'D-2026-001'
                && (float) $production->daily_total_liters === 21.7;
        });
        $response->assertSee('2 matching cows');
        $response->assertSee('D-2026-001');
        $response->assertSee('21.70');
        $response->assertSee('12.50');
        $response->assertSee('9.20');
        $response->assertDontSee('D-2026-003');
    }

    public function test_milk_production_search_filters_cows_for_the_selected_date(): void
    {
        $user = User::factory()->create();
        $holstein = $this->createDairyCow('D-2026-001', 'Holstein');
        $jersey = $this->createDairyCow('D-2026-002', 'Jersey');
        $this->createProduction($holstein, '2026-10-21', 'Morning', 12.5);
        $this->createProduction($jersey, '2026-10-21', 'Morning', 8.3);

        $response = $this->actingAs($user)->get(route('milk-productions.index', [
            'date' => '2026-10-21',
            'search' => 'Holstein',
        ]));

        $response->assertOk();
        $response->assertSee('D-2026-001');
        $response->assertDontSee('D-2026-002');
        $response->assertSee('1 matching cow');
    }

    public function test_milk_production_rows_can_be_sorted_by_daily_total(): void
    {
        $user = User::factory()->create();
        $higherYieldCow = $this->createDairyCow('D-2026-002', 'Jersey');
        $lowerYieldCow = $this->createDairyCow('D-2026-001', 'Holstein');
        $this->createProduction($higherYieldCow, '2026-10-21', 'Morning', 10);
        $this->createProduction($lowerYieldCow, '2026-10-21', 'Morning', 5);

        $response = $this->actingAs($user)->get(route('milk-productions.index', [
            'date' => '2026-10-21',
            'sort' => 'daily_total',
            'direction' => 'asc',
        ]));

        $response->assertOk();
        $response->assertViewHas('productions', function ($productions): bool {
            return $productions->getCollection()
                ->pluck('animal.animal_id')
                ->all() === ['D-2026-001', 'D-2026-002'];
        });
    }

    public function test_future_production_date_is_rejected(): void
    {
        $this->travelTo('2026-10-23 12:00:00');
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('milk-productions.index', [
            'date' => '2026-10-24',
        ]));

        $response->assertSessionHasErrors('date');
    }

    private function createDairyCow(string $animalId, string $breed): Animal
    {
        return Animal::create([
            'animal_id' => $animalId,
            'animal_type' => 'Dairy',
            'breed' => $breed,
            'sex' => 'Female',
            'date_of_birth' => '2022-03-18',
            'weight' => 465,
            'status' => 'Active',
        ]);
    }

    private function createProduction(
        Animal $animal,
        string $productionDate,
        string $session,
        float $quantity
    ): MilkProduction {
        return MilkProduction::create([
            'animal_id' => $animal->id,
            'production_date' => $productionDate,
            'session' => $session,
            'quantity_liters' => $quantity,
        ]);
    }
}
