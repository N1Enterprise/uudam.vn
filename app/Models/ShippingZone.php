<?php

namespace App\Models;

use App\Models\Traits\Activatable;

class ShippingZone extends BaseModel
{
    use Activatable;

    protected $fillable = [
        'name',
        'supported_countries',
        'status',
        'supported_provinces',
        'supported_districts',
        'supported_wards'
    ];

    protected $casts = [
        'supported_countries' => 'json',
        'supported_provinces' => 'json',
        'supported_districts' => 'json',
        'supported_wards' => 'json',
    ];
}
