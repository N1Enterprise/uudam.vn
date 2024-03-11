<?php

namespace App\Models;

class District extends BaseModel
{
    protected $primaryKey = 'code';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'code',
        'name',
        'name_en',
        'full_name',
        'full_name_en',
        'code_name',
        'province_code',
        'administrative_unit_id'
    ];

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_code', 'code');
    }
}
