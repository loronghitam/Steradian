<?php

namespace Database\Seeders;

use App\Models\Order;
use Database\Factories\OrderFactory;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        Order::factory(3)->create();
    }
}
