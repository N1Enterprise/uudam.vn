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

    public function allApproved()
    {
        $cacheKey = self::CACHE_TAG.':product_review_approved';

        return Cache::tags(self::CACHE_TAG)->rememberForever($cacheKey, function() {
            return $this->model()->query()
                ->scopes(['approved'])
                ->orderBy('created_at', 'desc')
                ->get([
                    'id', 
                    'user_name', 
                    'rating_type', 
                    'status', 
                    'created_at', 
                    'content'
                ])
                ->toArray();
        });
    }
}