<?php

namespace App\Models;

use App\Models\Traits\Activatable;

class ShippingZone extends BaseModel
{
    use Activatable;

    protected $fillable = [
        'name',
        'supported_countries',
        'status'
    ];

    protected $casts = [
        'supported_countries' => 'json'
    ];
}
