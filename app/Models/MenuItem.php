<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = [
        'item_id',
        'name',
        'description',
        'price',
        'category',
        'emoji',
        'image_url',
        'available',
        'availability_message',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'available' => 'boolean',
        'sort_order' => 'integer',
    ];
}
