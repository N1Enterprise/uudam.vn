<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Contracts\Responses\Frontend\ListLinkedInventoryResponseContract;
use App\Services\InventoryService;
use App\Services\StoreFront\UserSearchService;
use Illuminate\Http\Request;

class UserSearchController extends BaseApiController
{
    public $userSearchService;
    public $inventoryService;

    public function __construct(UserSearchService $userSearchService, InventoryService $inventoryService)
    {
        $this->userSearchService = $userSearchService;
        $this->inventoryService = $inventoryService;
    }

    public function suggest(Request $request)
    {
        $result = $this->userSearchService->suggest($request->all());

        return response()->json($result);
    }

    public function searchInventories(Request $request)
    {
        $inventories = $this->inventoryService->searchByUser(array_merge(['query' => $request->query], $request->all()));

        return $this->response(ListLinkedInventoryResponseContract::class, $inventories);
    }
}
