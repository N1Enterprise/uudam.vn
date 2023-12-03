<?php

namespace App\Models;

use App\Models\Traits\Activatable;

class Carrier extends BaseModel
{
    use Activatable;

    protected $fillable = [
        'name',
        'email',
        'logo',
        'phone',
        'params',
        'status'
    ];

    protected $casts = [
        'params' => 'json'
    ];
}
