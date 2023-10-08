<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListDisplayInventoryResponseContract;
use App\Services\DisplayInventoryService;
use Illuminate\Http\Request;

class DisplayInventoryController extends BaseApiController
{
    public $displayInventoryService;

    public function __construct(DisplayInventoryService $displayInventoryService)
    {
        $this->displayInventoryService = $displayInventoryService;
    }

    public function index(Request $request)
    {
        $displayInventories = $this->displayInventoryService->searchByAdmin($request->all());

        return $this->response(ListDisplayInventoryResponseContract::class, $displayInventories);
    }
}
