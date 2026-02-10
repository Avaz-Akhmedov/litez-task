<?php

namespace App\Models\Delivery;

use App\Enums\Delivery\OrderStatus;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_phone',
        'customer_email',
        'origin_address',
        'origin_lat',
        'origin_lng',
        'destination_address',
        'destination_lat',
        'destination_lng',
        'distance_km',
        'duration_minutes',
        'estimated_cost',
        'status',
        'paid_at',
    ];
    protected $casts = [
        'status' => OrderStatus::class,
        'paid_at' => 'datetime',
        'origin_lat' => 'float',
        'origin_lng' => 'float',
        'destination_lat' => 'float',
        'destination_lng' => 'float',
        'distance_km' => 'float',
        'estimated_cost' => 'float',
    ];
}
