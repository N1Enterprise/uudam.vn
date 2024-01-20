<?php

namespace App\Models;

use App\Models\Traits\Activatable;

class ShippingProvider extends BaseModel
{
    use Activatable;

    protected $fillable = [
        'name',
        'code',
        'params',
        'status',
        'logo',
        'supported_countries',
        'supported_provinces'
    ];

    protected $casts = [
        'params' => 'json',
        'supported_countries' => 'json',
        'supported_provinces' => 'json'
    ];
}
