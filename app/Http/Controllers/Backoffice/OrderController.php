<?php

namespace App\Http\Controllers\Backoffice;

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
        return view('backoffice.pages.orders.index');
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

        return view('backoffice.pages.orders.edit', compact('order'));
    }
}
