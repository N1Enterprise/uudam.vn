<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListOrderItemResponseContract;
use App\Services\OrderItemService;
use Illuminate\Http\Request;

class OrderItemController extends BaseApiController
{
    public $orderItemService;

    public function __construct(OrderItemService $orderItemService)
    {
        $this->orderItemService = $orderItemService;
    }

    public function index(Request $request)
    {
        $orders = $this->orderItemService->searchByAdmin($request->all());

        return $this->response(ListOrderItemResponseContract::class, $orders);
    }
}
