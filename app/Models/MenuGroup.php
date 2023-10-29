<?php

namespace App\Models;

use App\Models\Traits\Activatable;

class MenuGroup extends BaseModel
{
    use Activatable;

    protected $fillable = [
        'name',
        'redirect_url',
        'order',
        'status',
        'params',
    ];

    protected $casts = [
        'params' => 'json',
    ];

    public function menuSubGroups()
    {
        return $this->hasMany(MenuSubGroup::class);
    }
}
