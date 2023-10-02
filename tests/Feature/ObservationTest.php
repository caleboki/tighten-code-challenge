<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Capybara;
use App\Models\Observation;

class ObservationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function all_observations_can_be_viewed()
    {
        // Create multiple capybaras and observations
        $capybara1 = Capybara::factory()->create();
        $capybara2 = Capybara::factory()->create();

        $observation1 = Observation::factory()->create(['capybara_id' => $capybara1->id]);
        $observation2 = Observation::factory()->create(['capybara_id' => $capybara2->id]);

        $response = $this->getJson(route('v1.observations.all'));

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data'); // Expecting 2 observations in the "data" key
        $response->assertJsonFragment(['id' => $observation1->id]);
        $response->assertJsonFragment(['id' => $observation2->id]);
    }

    /** @test */
    public function an_empty_list_is_returned_when_there_are_no_observations()
    {
        $response = $this->getJson(route('v1.observations.all'));

        $response->assertStatus(200);
        $response->assertJson(['data' => []]); // Expecting an empty "data" array
    }

    /** @test */
    public function an_observation_can_be_created_successfully()
    {
        $capybara = Capybara::factory()->create();

        $observationData = [
            'capybara_id' => $capybara->id,
            'date' => '2023-10-03',
            'city' => 'Chicago',
            'hat' => false
        ];

        $response = $this->postJson(route('v1.capybaras.observations.store', $capybara), $observationData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('observations', $observationData);
    }

    /** @test */
    public function an_observation_requires_certain_fields()
    {
        $capybara = Capybara::factory()->create();

        $response = $this->postJson(route('v1.capybaras.observations.store', $capybara), []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['date', 'city']);
    }

    /** @test */
    public function only_the_first_observation_per_capybara_city_date_is_recorded()
    {
        // Create a capybara
        $capybara = Capybara::factory()->create();

        // Create an observation for the capybara
        $this->postJson("/api/v1/capybaras/{$capybara->id}/observations", [
            'date' => '2023-10-01',
            'city' => 'Chicago',
            'hat' => false
        ])->assertStatus(201);

        // Attempt to create another observation for the same capybara, city, and date
        $response = $this->postJson("/api/v1/capybaras/{$capybara->id}/observations", [
            'date' => '2023-10-01',
            'city' => 'Chicago',
            'hat' => true
        ]);

        // Assert that the request was unsuccessful
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('date');
    }


}
