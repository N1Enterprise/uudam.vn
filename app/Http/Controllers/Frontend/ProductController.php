<?php

namespace App\Http\Controllers\Frontend;

use App\Enum\ProductReviewRatingEnum;
use App\Services\AttributeService;
use App\Services\InventoryService;
use App\Services\PostService;
use App\Services\ProductReviewService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Services\StoreFront\StoreFrontProductDisplayService;

class ProductController extends BaseController
{
    public $storeFrontProductDisplayService;
    public $inventoryService;
    public $attributeService;
    public $postService;
    public $productReviewService;

    public function __construct(
        StoreFrontProductDisplayService $storeFrontProductDisplayService,
        InventoryService $inventoryService,
        AttributeService $attributeService,
        PostService $postService,
        ProductReviewService $productReviewService
    ) {
        $this->storeFrontProductDisplayService = $storeFrontProductDisplayService;
        $this->inventoryService = $inventoryService;
        $this->attributeService = $attributeService;
        $this->postService = $postService;
        $this->productReviewService = $productReviewService;
    }

    public function index(Request $request, $slug)
    {
        $inventory = $this->storeFrontProductDisplayService->showBySlug($slug);
        $variants  = $this->inventoryService->listAvailableByProduct($inventory->product_id, [
            'with' => ['attributeValues:id,value,color', 'attributes:id,name,attribute_type,order'],
            'columns' => ['id', 'title', 'stock_quantity', 'image', 'sale_price', 'slug', 'sku', 'condition_note', 'condition']
        ]);

        $imageGalleries = collect([$inventory->image])
            ->merge(collect(data_get($inventory, 'product.media.image', []))->map(fn($item) => data_get($item, 'path')))
            ->toArray();

        $mediaVideos = collect(data_get($inventory, 'product.media.video', []))
            ->map(fn($item) => data_get($item, 'path'))
            ->toArray();

        $inventoryAttributes = $inventory->attributeValues->pluck('id')->toArray();

        $attributes = $this->attributeService->getAttributesByInventories($variants->pluck('id')->toArray());

        $suggestedPosts = $this->postService->getAvailableBySuggested(data_get($inventory->product, 'suggested_relationships.posts'));
        $suggestedInventories = $this->inventoryService->getAvailableBySuggested(data_get($inventory->product, 'suggested_relationships.inventories'), ['with' => 'product:id,media,primary_image']);

        $productReviewRatingEnumLabels = ProductReviewRatingEnum::labelsInVietnamese();

        $productReviews = $this->productReviewService->allAvailable(['columns' => ['id', 'user_name', 'rating_type', 'status', 'created_at', 'content']]);

        return $this->view('frontend.pages.products.index', compact(
            'inventory',
            'variants',
            'imageGalleries',
            'mediaVideos',
            'attributes',
            'inventoryAttributes',
            'suggestedPosts',
            'suggestedInventories',
            'productReviewRatingEnumLabels',
            'productReviews',
        ));
    }
}
