<?php

namespace App\Models;

use App\Enum\ActivationStatusEnum;
use App\Models\Traits\Activatable;

class Category extends BaseModel
{
    use Activatable;

    protected $fillable = [
        'name',
        'slug',
        'category_group_id',
        'description',
        'primary_image',
        'status',
        'order',
        'meta_title',
        'meta_description',
    ];

    public function categoryGroup()
    {
        return $this->belongsTo(CategoryGroup::class, 'category_group_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_products');
    }
}
