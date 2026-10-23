<?php

namespace Tests\Feature;

use App\Models\Animal;
use App\Models\AnimalHealth;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnimalHealthManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_health_page_shows_record_and_follow_up_summaries(): void
    {
        $this->travelTo('2026-10-23 12:00:00');
        $user = User::factory()->create();
        $animal = $this->createAnimal('D-2026-001');

        $this->createHealthRecord($animal, '2026-10-10', 'Sick', 'Mastitis', '2026-10-22');
        $this->createHealthRecord($animal, '2026-10-12', 'Under Treatment', 'Injury', '2026-10-23');
        $this->createHealthRecord($animal, '2026-10-15', 'Healthy');
        $this->createHealthRecord($animal, '2026-10-16', 'Recovered');

        $response = $this->actingAs($user)->get(route('animal-health.index'));

        $response->assertOk();
        $response->assertSee('Animal Health');
        $response->assertSee('4 matching records');
        $response->assertViewHas('healthSummary', function ($summary): bool {
            $this->assertSame(4, (int) $summary->total_records);
            $this->assertSame(1, (int) $summary->sick_records);
            $this->assertSame(1, (int) $summary->treatment_records);
            $this->assertSame(2, (int) $summary->follow_ups_due);

            return true;
        });
    }

    public function test_health_search_filters_by_animal_and_diagnosis(): void
    {
        $user = User::factory()->create();
        $firstAnimal = $this->createAnimal('D-2026-001');
        $secondAnimal = $this->createAnimal('D-2026-002');
        $this->createHealthRecord($firstAnimal, '2026-10-10', 'Sick', 'Mastitis');
        $this->createHealthRecord($secondAnimal, '2026-10-11', 'Sick', 'Foot rot');

        $response = $this->actingAs($user)->get(route('animal-health.index', [
            'search' => 'Mastitis',
        ]));

        $response->assertOk();
        $response->assertSee('D-2026-001');
        $response->assertDontSee('D-2026-002');
        $response->assertSee('1 matching record');
    }

    public function test_health_records_are_filtered_by_status(): void
    {
        $user = User::factory()->create();
        $animal = $this->createAnimal('D-2026-001');
        $this->createHealthRecord($animal, '2026-10-10', 'Healthy');
        $this->createHealthRecord($animal, '2026-10-11', 'Under Treatment');

        $response = $this->actingAs($user)->get(route('animal-health.index', [
            'status' => 'Under Treatment',
        ]));

        $response->assertOk();
        $response->assertSee('Under Treatment');
        $response->assertSee('1 matching record');
        $response->assertViewHas('records', function ($records): bool {
            return $records->getCollection()->every(
                fn (AnimalHealth $record): bool => $record->health_status === 'Under Treatment'
            );
        });
    }

    public function test_health_records_can_be_sorted_by_checkup_date(): void
    {
        $user = User::factory()->create();
        $animal = $this->createAnimal('D-2026-001');
        $this->createHealthRecord($animal, '2026-10-12', 'Healthy');
        $this->createHealthRecord($animal, '2026-10-10', 'Sick');

        $response = $this->actingAs($user)->get(route('animal-health.index', [
            'sort' => 'checkup',
            'direction' => 'asc',
        ]));

        $response->assertOk();
        $response->assertViewHas('records', function ($records): bool {
            return $records->getCollection()
                ->pluck('checkup_date')
                ->map(fn ($date): string => $date->toDateString())
                ->all() === ['2026-10-10', '2026-10-12'];
        });
    }

    public function test_invalid_health_record_sort_parameter_is_rejected(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('animal-health.index', [
            'sort' => 'invalid',
        ]));

        $response->assertRedirect();
        $response->assertSessionHasErrors('sort');
    }

    public function test_invalid_health_status_filter_is_rejected(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('animal-health.index', [
            'status' => 'Critical',
        ]));

        $response->assertRedirect();
        $response->assertSessionHasErrors('status');
    }

    public function test_unauthenticated_user_is_redirected_from_animal_health(): void
    {
        $response = $this->get(route('animal-health.index'));

        $response->assertRedirect(route('login'));
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

    private function createHealthRecord(
        Animal $animal,
        string $checkupDate,
        string $status,
        ?string $disease = null,
        ?string $nextCheckupDate = null
    ): AnimalHealth {
        return AnimalHealth::create([
            'animal_id' => $animal->id,
            'checkup_date' => $checkupDate,
            'health_status' => $status,
            'disease' => $disease,
            'next_checkup_date' => $nextCheckupDate,
        ]);
    }
}
