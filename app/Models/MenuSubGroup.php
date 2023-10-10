<?php

namespace App\Models;

use App\Models\Traits\Activatable;

class MenuSubGroup extends BaseModel
{
    use Activatable;

    protected $fillable = [
        'name',
        'redirect_url',
        'menu_group_id',
        'order',
        'status',
    ];

    public function menuGroup()
    {
        return $this->belongsTo(MenuGroup::class, 'menu_group_id');
    }
}
