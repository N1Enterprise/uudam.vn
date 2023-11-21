<?php

namespace App\Models;

use App\Enum\CurrencyTypeEnum;
use App\Models\Traits\Activatable;

class Currency extends BaseModel
{
    use Activatable;

    protected $fillable = [
        'type',
        'name',
        'code',
        'symbol',
        'decimals',
        'status',
        'used_countries',
    ];

    protected $casts = [
        'used_countries' => 'json'
    ];

    public function getTypeNameAttribute()
    {
        return CurrencyTypeEnum::findConstantLabel($this->type);
    }
}
