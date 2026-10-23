<?php

namespace Tests\Feature;

use App\Models\Animal;
use App\Models\MilkProduction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_the_report_preview(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('reports.index'));

        $response->assertOk();
        $response->assertSee('Milk Production Report');
        $response->assertSee('Export Excel (CSV)');
        $response->assertSee('Generate preview');
    }

    public function test_monthly_milk_report_excludes_records_outside_the_selected_period(): void
    {
        $this->travelTo('2026-10-23 12:00:00');
        $user = User::factory()->create();
        $animal = Animal::create([
            'animal_id' => 'D-2026-001',
            'animal_type' => 'Dairy',
            'breed' => 'Holstein',
            'sex' => 'Female',
            'date_of_birth' => '2022-03-18',
            'weight' => 465,
            'status' => 'Active',
        ]);

        MilkProduction::create([
            'animal_id' => $animal->id,
            'production_date' => '2026-10-10',
            'session' => 'Morning',
            'quantity_liters' => 12,
        ]);
        MilkProduction::create([
            'animal_id' => $animal->id,
            'production_date' => '2026-09-10',
            'session' => 'Morning',
            'quantity_liters' => 50,
        ]);

        $response = $this->actingAs($user)->get(route('reports.index', [
            'report' => 'milk-production',
            'period' => 'monthly',
        ]));

        $response->assertOk();
        $response->assertSee('12.00');
        $response->assertDontSee('50.00');
    }

    public function test_invalid_report_selection_is_rejected(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('reports.index', [
            'report' => 'unknown-report',
        ]));

        $response->assertRedirect();
        $response->assertSessionHasErrors('report');
    }

    public function test_invalid_date_range_is_rejected(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('reports.index', [
            'period' => 'decade',
        ]));

        $response->assertRedirect();
        $response->assertSessionHasErrors('period');
    }

    public function test_each_report_type_can_be_previewed_without_records(): void
    {
        $user = User::factory()->create();

        foreach ([
            'animal-population',
            'milk-production',
            'sales-revenue',
            'breeding',
            'animal-health',
            'inventory',
            'staff-activities',
        ] as $report) {
            $response = $this->actingAs($user)->get(route('reports.index', ['report' => $report]));

            $response->assertOk();
        }
    }

    public function test_csv_export_uses_the_selected_report_name(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('reports.export', [
            'report' => 'milk-production',
            'period' => 'monthly',
        ]));

        $response->assertDownload('farm-milk_production-report.csv');
        $this->assertStringContainsString('Metric,Value', $response->streamedContent());
        $this->assertStringContainsString('Milk recorded today', $response->streamedContent());
    }

    public function test_unauthenticated_user_is_redirected_from_csv_export(): void
    {
        $response = $this->get(route('reports.export'));

        $response->assertRedirect(route('login'));
    }
}
