<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Contracts\Responses\Frontend\ListLinkedInventoryResponseContract;
use App\Services\HomePageDisplayItemService;
use App\Services\InventoryService;
use Illuminate\Support\Arr;

class UserHomePageDisplayItemController extends BaseApiController
{
    public $homePageDisplayItemService;
    public $inventoryService;

    public function __construct(HomePageDisplayItemService $homePageDisplayItemService, InventoryService $inventoryService)
    {
        parent::__construct();

        $this->homePageDisplayItemService = $homePageDisplayItemService;
        $this->inventoryService = $inventoryService;
    }

    public function getInventories($id)
    {
        $displayItem = $this->homePageDisplayItemService->show($id);

        $inventoryIds = Arr::wrap(data_get($displayItem, 'linked_items', []));

        $inventories = $this->inventoryService->searchByUser(['filter_ids' => $inventoryIds, 'with' => 'product']);

        return $this->response(ListLinkedInventoryResponseContract::class, $inventories);
    }
}
