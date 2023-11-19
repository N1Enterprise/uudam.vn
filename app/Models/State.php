<?php

namespace App\Models;

use App\Models\Traits\Activatable;

class State extends BaseModel
{
    use Activatable;

    protected $fillable = [
        'name',
        'country_id',
        'country_code',
        'iso2',
        'latitude',
        'longitude',
    ];
}
