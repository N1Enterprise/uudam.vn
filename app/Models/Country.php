<?php

namespace App\Models;

use App\Models\Traits\Activatable;

class Country extends BaseModel
{
    use Activatable;

    protected $fillable = [
        'name',
        'iso3',
        'numeric_code',
        'iso2',
        'phonecode',
        'capital',
        'currency',
        'currency_name',
        'currency_symbol',
        'tld',
        'native',
        'region',
        'subregion',
        'timezones',
        'translations',
        'latitude',
        'longitude',
        'emoji',
        'emojiU',
        'flag',
        'wikiDataId',
        'status',
    ];

    protected $casts = [
        'timezones' => 'json',
        'translations' => 'json',
    ];
}
