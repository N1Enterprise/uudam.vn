<?php

namespace App\Models;

use App\Models\Traits\Activatable;
use App\Models\Traits\HasFeUsage;

class MenuGroup extends BaseModel
{
    use Activatable;
    use HasFeUsage;

    protected $fillable = [
        'name',
        'redirect_url',
        'order',
        'status',
        'params',
        'display_on_frontend'
    ];

    protected $casts = [
        'params' => 'json',
    ];

    public function menuSubGroups()
    {
        return $this->hasMany(MenuSubGroup::class);
    }
}
