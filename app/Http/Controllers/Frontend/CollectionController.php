<?php

namespace App\Http\Controllers\Frontend;

use App\Exceptions\ModelNotFoundException;
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
        $collection = $this->collectionService->findBySlugForGuest($slug, $request->all());
        $linkedFeaturedInventories = $this->inventoryService->getAvailableByIds(data_get($collection, 'linked_featured_inventories', []));

        if (empty($collection)) {
            throw new ModelNotFoundException();
        }

        if ($collection->slug != $slug) {
            return redirect()->route('fe.web.collections.index', ['slug' => $collection->slug, 'id' => $collection->id]);
        }

        return $this->view('frontend.pages.collections.index', compact('collection', 'linkedFeaturedInventories'));
    }
}
