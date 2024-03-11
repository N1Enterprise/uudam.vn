<?php

namespace App\Models;

class Ward extends BaseModel
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
        'district_code',
        'administrative_unit_id',
    ];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_code', 'code');
    }
}
