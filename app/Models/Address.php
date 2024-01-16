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
        'is_default',
        'code'
    ];

    public function getFullAddressAttribute()
    {
        return vsprintf('%s, %s, %s, %s', [
            $this->address_line,
            optional($this->ward)->full_name,
            optional($this->district)->full_name,
            optional($this->province)->full_name,
        ]);
    }

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
