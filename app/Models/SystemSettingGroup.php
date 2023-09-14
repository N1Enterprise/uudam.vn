<?php

namespace App\Models;

use Illuminate\Support\Str;

class SystemSettingGroup extends BaseModel
{
    protected $fillable = [
        'name',
        'order'
    ];

    protected $appends = [
        'name_display'
    ];

    public function systemSettings()
    {
        return $this->hasMany(SystemSetting::class, 'group_id')->orderBy('order');
    }

    public function getNameDisplayAttribute()
    {
        return Str::title(str_replace('_', ' ', $this->name));
    }
}
