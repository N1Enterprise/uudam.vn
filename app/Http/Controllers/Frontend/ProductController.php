<?php

namespace App\Http\Controllers\Frontend;

use App\Enum\ProductReviewRatingEnum;
use App\Exceptions\ModelNotFoundException;
use App\Services\AttributeService;
use App\Services\InventoryService;
use App\Services\PostService;
use App\Services\ProductReviewService;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    public $inventoryService;
    public $attributeService;
    public $postService;
    public $productReviewService;

    public function __construct(
        InventoryService $inventoryService,
        AttributeService $attributeService,
        PostService $postService,
        ProductReviewService $productReviewService
    ) {
        $this->inventoryService = $inventoryService;
        $this->attributeService = $attributeService;
        $this->postService = $postService;
        $this->productReviewService = $productReviewService;
    }

    public function index(Request $request, $slug)
    {
        $inventory = $this->inventoryService->showBySlugForGuest($slug);

        if (empty($inventory)) throw new ModelNotFoundException();

        $variants = $this->inventoryService->searchVariantsByProductForGuest($inventory->product_id);

        $imageGalleries = collect([$inventory->image])
            ->merge(collect(data_get($inventory, 'product.media.image', []))->map(fn($item) => data_get($item, 'path')))
            ->toArray();

        $mediaVideos = collect(data_get($inventory, 'product.media.video', []))
            ->map(fn($item) => data_get($item, 'path'))
            ->toArray();

        $inventoryAttributes = $inventory->attributeValues->pluck('id')->toArray();

        $attributes = $this->attributeService->getAttributesByInventories($variants->pluck('id')->toArray());

        // $suggestedPosts = $this->postService->getAvailableBySuggested(data_get($inventory->product, 'suggested_relationships.posts'));
        // $suggestedInventories = $this->inventoryService->getAvailableBySuggested(data_get($inventory->product, 'suggested_relationships.inventories'), ['with' => 'product:id,media,primary_image']);

        $productReviewRatingEnumLabels = ProductReviewRatingEnum::labelsInVietnamese();

        $productReviews = $this->productReviewService->allAvailable(['columns' => ['id', 'user_name', 'rating_type', 'status', 'created_at', 'content']]);

        return $this->view('frontend.pages.products.index', compact(
            'inventory',
            'variants',
            'imageGalleries',
            'mediaVideos',
            'attributes',
            'inventoryAttributes',
            // 'suggestedPosts',
            // 'suggestedInventories',
            'productReviewRatingEnumLabels',
            'productReviews',
        ));
    }
}
