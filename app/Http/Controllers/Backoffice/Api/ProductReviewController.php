<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListProductReviewResponseContract;
use App\Services\ProductReviewService;
use Illuminate\Http\Request;

class ProductReviewController extends BaseApiController
{
    public $productReviewService;

    public function __construct(ProductReviewService $productReviewService)
    {
        $this->productReviewService = $productReviewService;
    }

    public function index(Request $request)
    {
        $productReviews = $this->productReviewService->searchByAdmin($request->all());

        return $this->response(ListProductReviewResponseContract::class, $productReviews);
    }
}
