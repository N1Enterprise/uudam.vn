<?php

namespace App\Http\Controllers\Frontend;

use App\Cms\ProductReviewCms;
use App\Common\Session;
use App\Enum\ProductReviewRatingEnum;
use App\Enum\SystemSettingKeyEnum;
use App\Exceptions\ModelNotFoundException;
use App\Models\SystemSetting;
use App\Services\AttributeService;
use App\Services\InventoryService;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ProductController extends BaseController
{
    public $inventoryService;
    public $attributeService;
    public $postService;
    public $productReviewService;

    public function __construct(
        InventoryService $inventoryService,
        AttributeService $attributeService,
        PostService $postService
    ) {
        $this->inventoryService = $inventoryService;
        $this->attributeService = $attributeService;
        $this->postService = $postService;
    }

    public function index(Request $request, $slug)
    {
        $inventory = $this->inventoryService->showBySlugForGuest($slug, $request->all());

        if (empty($inventory)) throw new ModelNotFoundException();

        $recentInventoriesIds = Session::make(Session::USER_RECENT_INVENTORIES)
            ->limit(13)
            ->putRecent(data_get($inventory, 'id'))
            ->toCollect()
            ->filter(fn($item) => $item != $inventory->id)
            ->toArray();

        if ($inventory->slug != $slug) {
            return redirect()->route('fe.web.products.index', ['slug' => $inventory->slug, 'sku' => $inventory->sku]);
        }

        $variants = $this->inventoryService->searchVariantsByProductForGuest($inventory->product_id);

        $imageGalleries = collect([$inventory->image])
            ->merge(collect(data_get($inventory, 'product.media.image', []))->map(fn($item) => data_get($item, 'path')))
            ->toArray();

        $mediaVideos = collect(data_get($inventory, 'product.media.video', []))
            ->map(fn($item) => data_get($item, 'path'))
            ->toArray();

        $inventoryAttributes = $inventory->attributeValues->pluck('id')->toArray();

        $attributes = $this->attributeService->getAttributesByInventories($variants->pluck('id')->toArray());

        $productReviewRatingEnumLabels = ProductReviewRatingEnum::labelsInVietnamese();

        $productReviews = collect(ProductReviewCms::make()
            ->allApproved($inventory->product_id))
            ->map(function($item) {
                return array_merge($item, [
                    'user_phone' => hide_phone_number(data_get($item, 'user_phone'))
                ]);
            })
            ->toArray();

        if ($inventory->final_sold_count < count($productReviews)) {
            $productReviews = [];
        }

        $affiliateSalesChannels = SystemSetting::from(SystemSettingKeyEnum::AFFILIATE_SALES_CHANNELS)->get(null, []);

        $suggestedPosts = collect(optional($inventory->product)->linkedPosts ?? []);

        // $suggestedPosts = $this->postService->getAvailableByIds(data_get($inventory->product, 'suggested_relationships.posts'));

        $suggestedInventories = $this->inventoryService->getAvailableByIds(data_get($inventory->product, 'suggested_relationships.inventories'), ['scope' => ['feDisplay']]);

        $recentInventories = empty($recentInventoriesIds) ? [] : $this->inventoryService->getAvailableByIds(Arr::wrap($recentInventoriesIds));

        $recentInventories = collect($recentInventories)->sortBy(function($model) use ($recentInventoriesIds) {
            return array_search($model->id, $recentInventoriesIds);
        })->values();

        return $this->view('frontend.pages.products.index', compact(
            'inventory',
            'variants',
            'imageGalleries',
            'mediaVideos',
            'attributes',
            'inventoryAttributes',
            'productReviewRatingEnumLabels',
            'productReviews',
            'affiliateSalesChannels',
            'suggestedPosts',
            'suggestedInventories',
            'recentInventories',
            'recentInventoriesIds'
        ));
    }
}
