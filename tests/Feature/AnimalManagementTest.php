<?php

namespace Tests\Feature;

use App\Models\Animal;
use App\Models\AnimalHealth;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnimalManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_sees_animal_summary_and_health_reviews_due(): void
    {
        $user = User::factory()->create();
        $activeDairyAnimal = $this->createAnimal('D-2026-001', 'Dairy', 'Active', 'Holstein');
        $this->createAnimal('B-2026-002', 'Beef', 'Sold', 'Boran');

        AnimalHealth::create([
            'animal_id' => $activeDairyAnimal->id,
            'checkup_date' => now()->subMonths(2)->toDateString(),
            'health_status' => 'Healthy',
            'next_checkup_date' => now()->subDay()->toDateString(),
        ]);
        AnimalHealth::create([
            'animal_id' => $activeDairyAnimal->id,
            'checkup_date' => now()->subMonth()->toDateString(),
            'health_status' => 'Healthy',
            'next_checkup_date' => now()->toDateString(),
        ]);

        $response = $this->actingAs($user)->get(route('animals.index'));

        $response->assertOk();
        $response->assertSee('Animal Management');
        $response->assertSee('2 matching records');
        $response->assertSee('1 dairy · 1 beef · 0 calves');
        $response->assertSee('Animals with a check-up due');
        $response->assertViewHas('dueHealthReviews', 1);
        $response->assertSee('D-2026-001');
        $response->assertSee('B-2026-002');
    }

    public function test_animal_search_only_displays_matching_records(): void
    {
        $user = User::factory()->create();
        $this->createAnimal('D-2026-001', 'Dairy', 'Active', 'Holstein');
        $this->createAnimal('B-2026-002', 'Beef', 'Active', 'Boran');

        $response = $this->actingAs($user)->get(route('animals.index', ['search' => 'Holstein']));

        $response->assertOk();
        $response->assertSee('D-2026-001');
        $response->assertDontSee('B-2026-002');
        $response->assertSee('1 matching record');
    }

    public function test_animal_records_are_sorted_by_the_selected_column(): void
    {
        $user = User::factory()->create();
        $this->createAnimal('B-2026-002', 'Beef', 'Active', 'Boran');
        $this->createAnimal('A-2026-001', 'Dairy', 'Active', 'Holstein');

        $response = $this->actingAs($user)->get(route('animals.index', [
            'sort' => 'animal_id',
            'direction' => 'asc',
        ]));

        $response->assertOk();
        $content = $response->getContent();
        $firstAnimalPosition = strpos($content, 'A-2026-001');
        $secondAnimalPosition = strpos($content, 'B-2026-002');

        $this->assertNotFalse($firstAnimalPosition);
        $this->assertNotFalse($secondAnimalPosition);
        $this->assertLessThan($secondAnimalPosition, $firstAnimalPosition);
    }

    public function test_animal_records_can_be_sorted_by_latest_health_check(): void
    {
        $user = User::factory()->create();
        $laterCheckAnimal = $this->createAnimal('B-2026-002', 'Beef', 'Active', 'Boran');
        $earlierCheckAnimal = $this->createAnimal('A-2026-001', 'Dairy', 'Active', 'Holstein');

        AnimalHealth::create([
            'animal_id' => $laterCheckAnimal->id,
            'checkup_date' => '2026-10-10',
            'health_status' => 'Healthy',
        ]);
        AnimalHealth::create([
            'animal_id' => $earlierCheckAnimal->id,
            'checkup_date' => '2026-10-01',
            'health_status' => 'Healthy',
        ]);

        $response = $this->actingAs($user)->get(route('animals.index', [
            'sort' => 'health_check',
            'direction' => 'asc',
        ]));

        $response->assertOk();
        $content = $response->getContent();
        $earlierCheckPosition = strpos($content, 'A-2026-001');
        $laterCheckPosition = strpos($content, 'B-2026-002');

        $this->assertNotFalse($earlierCheckPosition);
        $this->assertNotFalse($laterCheckPosition);
        $this->assertLessThan($laterCheckPosition, $earlierCheckPosition);
    }

    public function test_invalid_animal_sort_parameter_returns_unprocessable_content(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('animals.index', ['sort' => 'invalid']));

        $response->assertUnprocessable();
    }

    public function test_animal_detail_page_shows_the_record_and_latest_health_check(): void
    {
        $user = User::factory()->create();
        $animal = $this->createAnimal('D-2026-001', 'Dairy', 'Active', 'Holstein');
        AnimalHealth::create([
            'animal_id' => $animal->id,
            'checkup_date' => '2026-10-01',
            'health_status' => 'Healthy',
        ]);

        $response = $this->actingAs($user)->get(route('animals.show', $animal));

        $response->assertOk();
        $response->assertSee('D-2026-001');
        $response->assertSee('2026-10-01');
        $response->assertSee('Edit animal');
    }

    public function test_unauthenticated_user_is_redirected_from_animal_management(): void
    {
        $response = $this->get(route('animals.index'));

        $response->assertRedirect(route('login'));
    }

    private function createAnimal(string $animalId, string $type, string $status, string $breed): Animal
    {
        return Animal::create([
            'animal_id' => $animalId,
            'animal_type' => $type,
            'breed' => $breed,
            'sex' => 'Female',
            'date_of_birth' => '2022-03-18',
            'weight' => 465,
            'status' => $status,
        ]);
    }
}
