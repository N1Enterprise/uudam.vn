<?php

namespace App\Http\Controllers\Backoffice;

use App\Enum\OrderStatusEnum;
use App\Enum\PaymentStatusEnum;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    public $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orderStatusEnumLabels = OrderStatusEnum::labels();
        $paymentStatusEnumLabels = PaymentStatusEnum::labels();

        return view('backoffice.pages.orders.index', compact('orderStatusEnumLabels', 'paymentStatusEnumLabels'));
    }

    public function edit(Request $request, $id)
    {
        $order = $this->orderService->show($id, [
            'with' => [
                'user',
                'shippingRate',
                'shippingRate.carrier',
                'paymentOption',
                'orderItems'
            ]
        ]);

        $orderStatusEnumLabels = OrderStatusEnum::labels();
        $paymentStatusEnumLabels = PaymentStatusEnum::labels();

        return view('backoffice.pages.orders.edit', compact('order', 'orderStatusEnumLabels', 'paymentStatusEnumLabels'));
    }
}
