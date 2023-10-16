<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreProductReviewRequestContract;
use App\Contracts\Requests\Backoffice\UpdateProductReviewRequestContract;
use App\Contracts\Responses\Backoffice\DeleteProductReviewResponseContract;
use App\Contracts\Responses\Backoffice\StoreProductReviewResponseContract;
use App\Contracts\Responses\Backoffice\UpdateProductReviewResponseContract;
use App\Enum\ProductReviewRatingEnum;
use App\Enum\ProductReviewStatusEnum;
use App\Services\CategoryService;
use App\Services\ProductReviewService;

class ProductReviewController extends BaseController
{
    public $productReviewService;
    public $categoryService;

    public function __construct(ProductReviewService $productReviewService, CategoryService $categoryService)
    {
        $this->productReviewService = $productReviewService;
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $productReviewRatingEnumLabels = ProductReviewRatingEnum::labels();
        $productReviewStatusEnumLabels = ProductReviewStatusEnum::labels();
        $categories = $this->categoryService
            ->allAvailable(['with' => 'products', 'columns' => ['id', 'name']])
            ->filter(fn($category) => !$category->products->isEmpty());

        return view('backoffice.pages.product-reviews.index', compact('productReviewRatingEnumLabels', 'categories', 'productReviewStatusEnumLabels'));
    }

    public function create()
    {
        $productReviewRatingEnumLabels = ProductReviewRatingEnum::labels();
        $categories = $this->categoryService
            ->allAvailable(['with' => 'products', 'columns' => ['id', 'name']])
            ->filter(fn($category) => !$category->products->isEmpty());

        return view('backoffice.pages.product-reviews.create', compact('productReviewRatingEnumLabels', 'categories'));
    }

    public function edit($id)
    {
        $productReview = $this->productReviewService->show($id);
        $categories = $this->categoryService
            ->allAvailable(['with' => 'products', 'columns' => ['id', 'name']])
            ->filter(fn($category) => !$category->products->isEmpty());

        $productReviewStatusEnum = app(ProductReviewStatusEnum::class);

        $productReviewRatingEnumLabels = ProductReviewRatingEnum::labels();
        $productReviewStatusEnumLabels = ProductReviewStatusEnum::labels();


        return view('backoffice.pages.product-reviews.edit', compact('productReview', 'productReviewRatingEnumLabels', 'categories', 'productReviewStatusEnumLabels', 'productReviewStatusEnum'));
    }

    public function store(StoreProductReviewRequestContract $request)
    {
        $productReview = $this->productReviewService->create($request->validated());

        return $this->response(StoreProductReviewResponseContract::class, $productReview);
    }

    public function update(UpdateProductReviewRequestContract $request, $id)
    {
        $productReview = $this->productReviewService->update($request->validated(), $id);

        return $this->response(UpdateProductReviewResponseContract::class, $productReview);
    }

    public function destroy($id)
    {
        $status = $this->productReviewService->delete($id);

        return $this->response(DeleteProductReviewResponseContract::class, ['status' => $status]);
    }
}
