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
    ];

    protected $casts = [
        'params' => 'json',
    ];
}
