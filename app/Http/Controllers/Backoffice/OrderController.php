<?php

namespace App\Http\Controllers\Backoffice;

use App\Enum\OrderStatusEnum;
use App\Enum\PaymentStatusEnum;
use App\Services\OrderService;
use App\Services\ShippingProviderService;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    public $orderService;
    public $shippingProviderService;

    public function __construct(OrderService $orderService, ShippingProviderService $shippingProviderService)
    {
        $this->orderService = $orderService;
        $this->shippingProviderService = $shippingProviderService;
    }

    public function index()
    {
        $orderStatusEnumLabels = OrderStatusEnum::labels();
        $paymentStatusEnumLabels = PaymentStatusEnum::labels();

        return view('backoffice.pages.orders.index', compact('orderStatusEnumLabels', 'paymentStatusEnumLabels'));
    }

    public function edit(Request $request, $id)
    {
        $order = $this->orderService->show($id, ['with' => ['user', 'shippingRate', 'shippingRate.carrier', 'paymentOption', 'orderItems', 'shippingOption']]);
        $orderStatusEnumLabels = OrderStatusEnum::labels();
        $paymentStatusEnumLabels = PaymentStatusEnum::labels();
        $shippingProviders = $this->shippingProviderService->allAvailable();

        return view('backoffice.pages.orders.edit', compact(
            'order', 
            'orderStatusEnumLabels', 
            'paymentStatusEnumLabels', 
            'shippingProviders'
        ));
    }
}
