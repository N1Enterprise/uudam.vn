<?php

namespace App\Models;

use App\Models\Traits\Activatable;

class MenuSubGroup extends BaseModel
{
    use Activatable;

    protected $fillable = [
        'name',
        'redirect_url',
        'menu_category_id',
        'order',
        'status',
    ];
}
