<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Contracts\Requests\Frontend\UserOrderRequestContract;
use App\Contracts\Responses\Frontend\UserOrderResponseContract;
use App\Services\UserOrderService;
use Illuminate\Http\Request;

class UserOrderController extends BaseApiController
{
    public $userOrderService;

    public function __construct(UserOrderService $userOrderService)
    {
        parent::__construct();

        $this->userOrderService = $userOrderService;
    }

    public function order(UserOrderRequestContract $request, $cartUuid)
    {
        $user = $this->user();
        $order = $this->userOrderService->order(
            $user->getKey(),
            $cartUuid,
            $request->payment_option_id,
            $request->shipping_rate_id,
            $user,
            $request->validated()
        );

        return $this->response(UserOrderResponseContract::class, $order);
    }

    public function reorder(Request $request, $orderCode)
    {
        $order = $this->userOrderService->reorderPaymentByOrderCode($this->user()->getKey(), $orderCode, $request->all());

        return $this->response(UserOrderResponseContract::class, $order);
    }
}
