<?php

namespace App\Models;

use App\Models\Traits\Activatable;

class CategoryGroup extends BaseModel
{
    use Activatable;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon_image',
        'order',
        'status',
        'meta_title',
        'meta_description'
    ];
}
