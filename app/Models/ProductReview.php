<?php

namespace App\Models;

use App\Enum\ProductReviewRatingEnum;
use App\Enum\ProductReviewStatusEnum;
use App\Models\Traits\HasImpactor;

class ProductReview extends BaseModel
{
    use HasImpactor;

    protected $fillable = [
        'user_name',
        'user_phone',
        'user_email',
        'rating_type',
        'content',
        'status',
        'is_real_user',
        'product_id',
        'note',
        'created_by_id',
        'created_by_type',
        'updated_by_type',
        'updated_by_id',
        'is_purchased',
        'images',
        'post_at'
    ];

    protected $casts = [
        'images' => 'json'
    ];

    public function getStatusNameAttribute()
    {
        return ProductReviewStatusEnum::findConstantLabel($this->status);
    }

    public function getRatingTypeNameAttribute()
    {
        return ProductReviewRatingEnum::findConstantLabel($this->rating_type);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', ProductReviewStatusEnum::APPROVED);
    }

    public function scopePending($query)
    {
        return $query->where('status', ProductReviewStatusEnum::PENDING);
    }

    public function isApproved()
    {
        return $this->status == ProductReviewStatusEnum::APPROVED;
    }

    public function isDeclined()
    {
        return $this->status == ProductReviewStatusEnum::DECLINED;
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
