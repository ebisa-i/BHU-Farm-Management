<?php

namespace Tests\Feature;

use App\Models\Animal;
use App\Models\Breeding;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BreedingManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_breeding_page_shows_real_status_and_date_summaries(): void
    {
        $this->travelTo('2026-10-23 12:00:00');
        $user = User::factory()->create();
        $femaleAnimal = $this->createAnimal('D-2026-001', 'Female');

        $this->createBreeding(
            $femaleAnimal,
            '2026-10-10',
            'Pregnant',
            'Artificial Insemination',
            '2026-11-10'
        );
        $this->createBreeding(
            $femaleAnimal,
            '2026-10-12',
            'Pending',
            'Natural',
            '2026-11-20'
        );
        $this->createBreeding(
            $femaleAnimal,
            '2026-09-10',
            'Calved',
            'Natural',
            '2026-06-01',
            '2026-10-01'
        );

        $response = $this->actingAs($user)->get(route('breedings.index'));

        $response->assertOk();
        $response->assertViewHas('breedingSummary', function ($summary): bool {
            return (int) $summary->pregnant_cows === 1
                && (int) $summary->due_within_30_days === 2
                && (int) $summary->inseminations_this_month === 1
                && (int) $summary->calves_born_this_year === 1;
        });
        $response->assertSee('3 matching records');
        $response->assertSee('Pregnant');
        $response->assertSee('BRD-001');
        $response->assertSee('Calved');
        $response->assertViewHas('breedings', function ($breedings): bool {
            return $breedings->getCollection()
                ->contains(fn (Breeding $breeding): bool => $breeding->actual_calving_date?->toDateString() === '2026-10-01');
        });
    }

    public function test_breeding_search_filters_by_animal_id_and_method(): void
    {
        $user = User::factory()->create();
        $firstFemale = $this->createAnimal('D-2026-001', 'Female');
        $secondFemale = $this->createAnimal('D-2026-002', 'Female');
        $this->createBreeding($firstFemale, '2026-10-10', 'Pending', 'Natural');
        $this->createBreeding($secondFemale, '2026-10-11', 'Pregnant', 'Artificial Insemination');

        $response = $this->actingAs($user)->get(route('breedings.index', [
            'search' => 'D-2026-002',
        ]));

        $response->assertOk();
        $response->assertSee('D-2026-002');
        $response->assertDontSee('D-2026-001');
        $response->assertSee('1 matching record');
    }

    public function test_breeding_records_can_be_sorted_by_expected_calving_date(): void
    {
        $user = User::factory()->create();
        $female = $this->createAnimal('D-2026-001', 'Female');
        $this->createBreeding($female, '2026-10-10', 'Pending', 'Natural', '2027-02-01');
        $this->createBreeding($female, '2026-10-11', 'Pregnant', 'Natural', '2027-01-01');

        $response = $this->actingAs($user)->get(route('breedings.index', [
            'sort' => 'expected_calving',
            'direction' => 'asc',
        ]));

        $response->assertOk();
        $response->assertViewHas('breedings', function ($breedings): bool {
            return $breedings->getCollection()
                ->pluck('expected_calving_date')
                ->map(fn ($date): string => $date->toDateString())
                ->all() === ['2027-01-01', '2027-02-01'];
        });
    }

    public function test_invalid_breeding_sort_parameter_is_rejected(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('breedings.index', [
            'sort' => 'invalid',
        ]));

        $response->assertRedirect();
        $response->assertSessionHasErrors('sort');
    }

    private function createAnimal(string $animalId, string $sex): Animal
    {
        return Animal::create([
            'animal_id' => $animalId,
            'animal_type' => 'Dairy',
            'breed' => 'Holstein',
            'sex' => $sex,
            'date_of_birth' => '2022-03-18',
            'weight' => 465,
            'status' => 'Active',
        ]);
    }

    private function createBreeding(
        Animal $female,
        string $matingDate,
        string $status,
        string $method,
        ?string $expectedCalvingDate = null,
        ?string $actualCalvingDate = null
    ): Breeding {
        return Breeding::create([
            'female_animal_id' => $female->id,
            'mating_date' => $matingDate,
            'expected_calving_date' => $expectedCalvingDate,
            'actual_calving_date' => $actualCalvingDate,
            'breeding_method' => $method,
            'status' => $status,
        ]);
    }
}
