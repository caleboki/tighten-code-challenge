<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Capybara>
 */
class CapybaraFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $names = ['Colossus', 'Steven', 'Capybaby'];

        return [
            'name' => $this->faker->unique()->randomElement($names),
            'color' => $this->faker->safeColorName,
            'size' => $this->faker->randomElement(['small', 'medium', 'large']),
        ];
    }
}
