<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pickup_location' => '',
            'dropoff_location' => '',
            'dropoff_date' => '',
            'order_date' => '',
            'pickup_date' => '',
            'car_id' => Car::get()->random()->id
        ];
    }
}
