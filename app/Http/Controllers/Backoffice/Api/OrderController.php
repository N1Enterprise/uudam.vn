<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListOrderResponseContract;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends BaseApiController
{
    public $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $orders = $this->orderService->searchByAdmin($request->all());

        return $this->response(ListOrderResponseContract::class, $orders);
    }
}
