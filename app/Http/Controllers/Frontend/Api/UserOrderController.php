<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Common\RequestHelper;
use App\Contracts\Requests\Frontend\UserCancelOrderRequestContract;
use App\Contracts\Requests\Frontend\UserOrderRequestContract;
use App\Contracts\Responses\Frontend\UserOrderResponseContract;
use App\Services\OrderService;
use App\Services\UserOrderService;
use Illuminate\Http\Request;

class UserOrderController extends BaseApiController
{
    public $userOrderService;
    public $orderService;

    public function __construct(UserOrderService $userOrderService, OrderService $orderService)
    {
        parent::__construct();

        $this->userOrderService = $userOrderService;
        $this->orderService = $orderService;
    }

    public function order(UserOrderRequestContract $request, $cartUuid)
    {
        $dataValidated = $request->validated();
        $dataValidated['footprint'] = RequestHelper::getDataFromRequest($request, config('security.footprint_fields'));

        $order = $this->userOrderService->order(
            $this->user(),
            $cartUuid,
            $request->payment_option_id,
            $request->shipping_option_id,
            $request->address_id,
            $this->user(),
            $dataValidated
        );

        return $this->response(UserOrderResponseContract::class, $order);
    }

    public function reorder(Request $request, $orderCode)
    {
        $order = $this->userOrderService->reorderPaymentByOrderCode($this->user()->getKey(), $orderCode, $request->all());

        return $this->response(UserOrderResponseContract::class, $order);
    }

    public function cancel(UserCancelOrderRequestContract $request, $orderCode)
    {
        $order = $this->userOrderService->cancelByUser($this->user(), $orderCode, $request->validated());

        return $this->response(UserOrderResponseContract::class, $order);
    }
}
