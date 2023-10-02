<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Capybara;


class CapybaraTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_capybara_can_be_created_successfully()
    {
        $capybaraData = [
            'name' => 'Steven',
            'color' => 'silver',
            'size' => 'large',
        ];

        $response = $this->postJson('/api/v1/capybaras', $capybaraData);

        $response->assertStatus(201)
                ->assertJsonFragment($capybaraData);

        $this->assertDatabaseHas('capybaras', $capybaraData);
    }

    /** @test */
    public function a_capybara_cannot_have_a_duplicate_name()
    {
        // Create a capybara
        Capybara::factory()->create(['name' => 'Steven']);

        // Attempt to create another capybara with the same name
        $response = $this->postJson('/api/v1/capybaras', [
            'name' => 'Steven',
            'color' => 'Brown',
            'size' => 'Large'
        ]);

        // Assert that the request was unsuccessful
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('name');
    }

    /** @test */
    public function a_capybara_requires_name_color_and_size()
    {
        $response = $this->postJson('/api/v1/capybaras', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name', 'color', 'size']);
    }
}
