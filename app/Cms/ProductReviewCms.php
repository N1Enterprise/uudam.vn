<?php

namespace App\Cms;

use App\Common\Cache;
use App\Models\ProductReview;

class ProductReviewCms extends BaseCms
{
    public const CACHE_TAG = 'product_review_cms';

    /**
     * @return ProductReview
     * @throws BindingResolutionException
     */
    public function model()
    {
        return app(ProductReview::class);
    }

    public function allApproved($productId)
    {
        $cacheKey = self::CACHE_TAG.':product_review_approved:'.$productId;

        return Cache::tags(self::CACHE_TAG)->rememberForever($cacheKey, function() use ($productId) {
            return $this->model()->query()
                ->scopes(['approved'])
                ->where('product_id', $productId)
                ->orderBy('created_at', 'desc')
                ->get([
                    'id',
                    'user_name',
                    'rating_type',
                    'status',
                    'created_at',
                    'content',
                    'is_purchased',
                    'images',
                    'post_at'
                ])
                ->toArray();
        });
    }
}
