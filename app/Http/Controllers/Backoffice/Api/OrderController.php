<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Requests\Backoffice\UpdateOrderStatusRequestContract;
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

    public function changeStatus(UpdateOrderStatusRequestContract $request, $id)
    {
        $this->orderService->update($request->validated(), $id);

        return $this->responseNoContent();
    }

    public function statisticOrderStatus(Request $request, $orderStatus)
    {
        $count = $this->orderService->statisticOrderStatus($orderStatus, $request->all());

        return response()->json(['count' => $count]);
    }
}
