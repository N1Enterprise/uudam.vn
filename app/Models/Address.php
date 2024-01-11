<?php

namespace App\Models;

class Address extends BaseModel
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'province_code',
        'district_code',
        'ward_code',
        'address_line',
        'addressable_type',
        'addressable_id',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_code', 'code');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_code', 'code');
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_code', 'code');
    }
}
