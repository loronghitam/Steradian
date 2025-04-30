<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'car_name' => fake()->name,
            'day_rate' => fake()->numberBetween(300000, 500000),
            'month_rate' => fake()->numberBetween(6000000, 15000000),
            'image' => fake()->image
        ];
    }
}
