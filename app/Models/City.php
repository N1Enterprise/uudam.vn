<?php

namespace App\Models;

class City extends BaseModel
{
    protected $fillable = [
        'name',
        'country_id',
        'country_code',
        'latitude',
        'longitude',
        'flag',
        'wikiDataId',
    ];
}
