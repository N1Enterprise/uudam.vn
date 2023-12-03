<?php

namespace App\Http\Controllers\Frontend;

use App\Services\OrderService;
use App\Services\UserOrderService;

class UserOrderController extends AuthenticatedController
{
    public $userOrderService;
    public $orderService;

    public function __construct(UserOrderService $userOrderService, OrderService $orderService)
    {
        parent::__construct();

        $this->userOrderService = $userOrderService;
        $this->orderService = $orderService;
    }

    public function orderHistory()
    {
        $orders = $this->orderService->searchByUser($this->user()->getKey());

        return $this->view('frontend.pages.profile.order-history', compact('orders'));
    }

    public function orderHistoryDetail($orderCode)
    {
        $order = $this->orderService->findByUserAndCode($this->user()->getKey(), $orderCode);

        if (empty($order)) {
            return redirect()->route('fe.web.home');
        }

        return $this->view('frontend.pages.profile.order-history-detail', compact('order'));
    }
}
