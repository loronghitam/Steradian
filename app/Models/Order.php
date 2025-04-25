<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory, HasUlids;

    protected $fillable = ['order_date', 'pickup_date', 'dropoff_date', 'pickup_location', 'dropoff_location', 'car'];
}
