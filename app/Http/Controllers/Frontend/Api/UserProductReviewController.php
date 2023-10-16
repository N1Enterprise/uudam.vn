<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Contracts\Requests\Frontend\StoreUserProductReviewRequestContract;
use App\Contracts\Responses\Frontend\StoreUserProductReviewResponseContract;
use App\Services\ProductReviewService;

class UserProductReviewController extends BaseApiController
{
    public $productReviewService;

    public function __construct(ProductReviewService $productReviewService) {
        $this->productReviewService = $productReviewService;
    }

    public function review(StoreUserProductReviewRequestContract $request)
    {
        $productReview = $this->productReviewService->create($request->validated());

        $resource = optional($productReview)->only(['status', 'status_name', 'rating_type_name', 'user_name', 'created_at', 'content']);

        return $this->response(StoreUserProductReviewResponseContract::class, $resource);
    }
}
