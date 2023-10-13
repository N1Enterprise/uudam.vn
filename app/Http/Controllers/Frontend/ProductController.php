<?php

namespace App\Http\Controllers\Frontend;

use App\Services\AttributeService;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use App\Services\StoreFront\StoreFrontProductDisplayService;

class ProductController extends BaseController
{
    public $storeFrontProductDisplayService;
    public $inventoryService;
    public $attributeService;

    public function __construct(
        StoreFrontProductDisplayService $storeFrontProductDisplayService,
        InventoryService $inventoryService,
        AttributeService $attributeService
    ) {
        $this->storeFrontProductDisplayService = $storeFrontProductDisplayService;
        $this->inventoryService = $inventoryService;
        $this->attributeService = $attributeService;
    }

    public function index(Request $request, $slug)
    {
        $inventory = $this->storeFrontProductDisplayService->showBySlug($slug);
        $variants  = $this->inventoryService->listAvailableByProduct($inventory->product_id, ['with' => [
            'attributeValues:id,value,color',
            'attributes:id,name,attribute_type,order',
        ]]);

        $imageGalleries = collect([$inventory->image])
            ->merge(collect(data_get($inventory, 'product.media', []))->map(fn($item) => data_get($item, 'path')))
            ->toArray();

        return $this->view('frontend.pages.products.index', compact('inventory', 'imageGalleries'));
    }
}
