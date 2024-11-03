<?php

namespace App\Models;

use App\Enum\ProductReviewRatingEnum;
use App\Enum\ProductReviewStatusEnum;
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
        'slug',
        'code',
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
        'suggested_relationships' => 'json'
    ];

    protected $appends = [
        'review_count',
        'positive_review_count'
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

    public function getReviewCountAttribute()
    {
        return $this->reviews
            ->where('status', ProductReviewStatusEnum::APPROVED)
            ->count();
    }

    public function getPositiveReviewCountAttribute()
    {
        return $this->reviews
            ->where('status', ProductReviewStatusEnum::APPROVED)
            ->whereIn('rating_type', [
                ProductReviewRatingEnum::VERY_GOOD,
                ProductReviewRatingEnum::GOOD,
            ])
            ->count();
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function linkedPosts()
    {
        return $this->belongsToMany(Post::class, 'product_post_linkeds', 'product_id', 'post_id')->withTimestamps();
    }
}

