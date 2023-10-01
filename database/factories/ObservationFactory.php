<?php

namespace Database\Factories;

use App\Models\Observation;
use App\Models\Capybara;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Observation>
 */
class ObservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Observation::class;

    public function definition(): array
    {
        $cities = ['Chicago', 'Atlanta', 'New York', 'Houston', 'San Francisco'];
        return [
            'capybara_id' => Capybara::all()->random()->id,
            'date' => $this->faker->date(),
            'city' => $this->faker->randomElement($cities),
            'hat' => $this->faker->boolean,
        ];
    }
}
