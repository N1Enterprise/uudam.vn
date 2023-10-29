<?php

namespace App\Http\Controllers\Frontend;

use App\Services\CollectionService;
use App\Services\InventoryService;
use Illuminate\Http\Request;

class CollectionController extends BaseController
{
    public $collectionService;
    public $inventoryService;

    public function __construct(CollectionService $collectionService, InventoryService $inventoryService)
    {
        $this->collectionService = $collectionService;
        $this->inventoryService = $inventoryService;
    }

    public function index(Request $request, $slug)
    {
        $collection = $this->collectionService->showBySlug($slug);
        $linkedFeaturedInventories =$this->inventoryService->getAvailableByIds(data_get($collection, 'linked_featured_inventories', []));

        return $this->view('frontend.pages.collections.index', compact('collection', 'linkedFeaturedInventories'));
    }
}
