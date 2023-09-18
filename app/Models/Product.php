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
        'min_amount',
        'max_amount',
        'type',
        'status',
        'primary_image',
        'media',
        'created_by_type',
        'created_by_id',
        'updated_by_type',
        'updated_by_id',
    ];

    protected $casts = [
        'description' => 'json',
        'media' => 'json',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_products');
    }

    public function getTypeNameAttribute()
    {
        return ProductTypeEnum::findConstantLabel($this->type);
    }
}
