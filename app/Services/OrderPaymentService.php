<?php

namespace App\Services;

use App\Common\Cache;
use App\Enum\OrderCacheKeyEnum;
use App\Enum\OrderStatusEnum;
use App\Enum\PaymentStatusEnum;
use App\Events\Order\OrderPaymentApproved;
use App\Events\Order\OrderPaymentCancel;
use App\Events\Order\OrderPaymentDeclined;
use App\Exceptions\BusinessLogicException;
use App\Exceptions\ExceptionCode;
use App\Services\BaseService;
use App\Models\Order;

class OrderPaymentService extends BaseService
{
    public $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function approve($order, $data = [])
    {
        $cacheKey = OrderCacheKeyEnum::getOrderCacheKey(OrderCacheKeyEnum::ORDER_PAYMENT, get_model_key($order));

        return Cache::lock($cacheKey, OrderCacheKeyEnum::TTL)
            ->block(OrderCacheKeyEnum::MAXIMUM_WAIT, function() use ($order, $data) {
                /** @var Order */
                $order = $this->orderService->show($order);

                if (! $order->isPendingPayment()) {
                    throw new BusinessLogicException("Unable to approve order payment #{$order->id}.", ExceptionCode::INVALID_ORDER);
                }

                $updateResource = array_merge([
                    'payment_status' => PaymentStatusEnum::APPROVED,
                    'order_status' => OrderStatusEnum::PROCESSING
                ], $data);

                $order = $this->orderService->update($updateResource, $order);

                OrderPaymentApproved::dispatch($order);

                return $order;
            });
    }

    public function decline($order, $data = [])
    {
        $cacheKey = OrderCacheKeyEnum::getOrderCacheKey(OrderCacheKeyEnum::ORDER_PAYMENT, get_model_key($order));

        return Cache::lock($cacheKey, OrderCacheKeyEnum::TTL)
            ->block(OrderCacheKeyEnum::MAXIMUM_WAIT, function() use ($order, $data) {
                /** @var Order */
                $order = $this->orderService->show($order);

                if (! $order->isPendingPayment()) {
                    throw new BusinessLogicException("Unable to decline order payment #{$order->id}.", ExceptionCode::INVALID_ORDER);
                }

                $updateResource = array_merge([
                    'payment_status' => PaymentStatusEnum::DECLINED,
                    'order_status' => OrderStatusEnum::DECLINED,
                ], $data);

                $order = $this->orderService->update($updateResource, $order);

                OrderPaymentDeclined::dispatch($order);

                return $order;
            });
    }

    public function cancel($order, $data = [])
    {
        $cacheKey = OrderCacheKeyEnum::getOrderCacheKey(OrderCacheKeyEnum::ORDER_PAYMENT, get_model_key($order));

        return Cache::lock($cacheKey, OrderCacheKeyEnum::TTL)
            ->block(OrderCacheKeyEnum::MAXIMUM_WAIT, function() use ($order, $data) {
                /** @var Order */
                $order = $this->orderService->show($order);

                if (! $order->isPendingPayment()) {
                    throw new BusinessLogicException("Unable to cancel order payment #{$order->id}.", ExceptionCode::INVALID_ORDER);
                }

                $updateResource = array_merge([
                    'payment_status' => PaymentStatusEnum::CANCELED,
                    'order_status' => OrderStatusEnum::CANCELED,
                ], $data);

                $order = $this->orderService->update($updateResource, $order);

                OrderPaymentCancel::dispatch($order);

                return $order;
            });
    }
}
