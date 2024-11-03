<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Requests\Backoffice\UpdateOrderShippingRequestContract;
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

    public function delivery(UpdateOrderStatusRequestContract $request, $id)
    {
        $this->orderService->delivery($id, $request->validated());

        return response()->json(['success' => true]);
    }

    public function complete(UpdateOrderStatusRequestContract $request, $id)
    {
        $this->orderService->complete($id, $request->validated());

        return response()->json(['success' => true]);
    }

    public function cancel(UpdateOrderStatusRequestContract $request, $id)
    {
        $this->orderService->cancel($id, $request->validated());

        return response()->json(['success' => true]);
    }

    public function refund(UpdateOrderStatusRequestContract $request, $id)
    {
        $this->orderService->refund($id, $request->validated());

        return response()->json(['success' => true]);
    }

    public function updateShipping(UpdateOrderShippingRequestContract $request, $id)
    {
        $this->orderService->updateShipping(
            $id, 
            $request->user_order_shipping_history_id,
            $request->shipping_provider_id,
            $request->transport_fee,
            $request->reference_id,
        );

        return response()->json(['success' => true]);
    }
}
