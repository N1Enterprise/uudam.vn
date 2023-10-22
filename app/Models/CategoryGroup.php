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
        'primary_image',
        'order',
        'status',
        'meta_title',
        'meta_description',
        'primary_image',
    ];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
