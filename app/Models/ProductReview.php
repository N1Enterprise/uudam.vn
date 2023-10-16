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
        'product_id',
        'created_by_id',
        'created_by_type',
        'updated_by_type',
        'updated_by_id',
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
}
