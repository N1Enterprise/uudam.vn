<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListInventoryResponseContract;
use App\Services\InventoryService;
use Illuminate\Http\Request;

class InventoryController extends BaseApiController
{
    public $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    public function index(Request $request)
    {
        $inventories = $this->inventoryService->searchByAdmin($request->all());

        return $this->response(ListInventoryResponseContract::class, $inventories);
    }
}
