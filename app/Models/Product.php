<?php

namespace App\Models;

use App\Enum\ProductTypeEnum;
use App\Models\Traits\Activatable;
use App\Models\Traits\HasImpactor;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends BaseModel
{
    use SoftDeletes;
    use Activatable;
    use HasImpactor;

    protected $fillable = [
        'name',
        'code',
        'slug',
        'branch',
        'description',
        'type',
        'status',
        'primary_image',
        'media',
        'suggested_relationships',
        'created_by_type',
        'created_by_id',
        'updated_by_type',
        'updated_by_id',
    ];

    protected $casts = [
        'media' => 'json',
        'description' => 'json',
        'suggested_relationships' => 'json'
    ];

    public function getTypeNameAttribute()
    {
        return ProductTypeEnum::findConstantLabel($this->type);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_products');
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }
}

