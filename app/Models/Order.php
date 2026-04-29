<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_phone',
        'customer_address',
        'order_type',
        'notes',
        'admin_message',
        'items',
        'total',
        'status',
        'status_updated_at',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'items' => 'array',
        'total' => 'decimal:2',
        'status_updated_at' => 'datetime',
    ];
}
