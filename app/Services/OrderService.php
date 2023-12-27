<?php

namespace App\Services;

use App\Common\Cache;
use App\Enum\OrderCacheKeyEnum;
use App\Enum\OrderStatusEnum;
use App\Enum\PaymentStatusEnum;
use App\Events\Order\OrderDeclined;
use App\Events\Order\OrderPaymentApproved;
use App\Exceptions\BusinessLogicException;
use App\Exceptions\ExceptionCode;
use App\Models\BaseModel;
use App\Repositories\Contracts\OrderRepositoryContract;
use App\Services\BaseService;
use App\Models\PaymentOption;
use App\Models\ShippingRate;
use App\Models\User;
use App\Models\Cart;
use App\Vendors\Localization\Money;
use Illuminate\Support\Str;
use App\Models\Order;
use Illuminate\Support\Arr;

class OrderService extends BaseService
{
    public $orderRepository;
    public $paymentOptionService;
    public $shippingRateService;
    public $cartService;
    public $userService;

    public function __construct(
        OrderRepositoryContract $orderRepository,
        PaymentOptionService $paymentOptionService,
        ShippingRateService $shippingRateService,
        CartService $cartService,
        UserService $userService
    ) {
        $this->orderRepository = $orderRepository;
        $this->paymentOptionService = $paymentOptionService;
        $this->shippingRateService = $shippingRateService;
        $this->cartService = $cartService;
        $this->userService = $userService;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->orderRepository
            ->with(['createdBy', 'updatedBy', 'user', 'shippingRate', 'paymentOption'])
            ->whereColumnsLike($data['query'] ?? null, ['uuid', 'order_code', 'currency_code', 'fullname', 'email', 'phone', 'company'])
            ->scopeQuery(function($q) use ($data) {
                if ($userId = data_get($data, 'user_id')) {
                    $q->where('user_id', $userId);
                }

                if ($createdAtRange = data_get($data, 'created_at_range', [])) {
                    $q->whereBetween('created_at', $createdAtRange);
                }

                if ($fullname = data_get($data, 'fullname')) {
                    $q->where('fullname', $fullname);
                }

                if ($email = data_get($data, 'email')) {
                    $q->where('email', $email);
                }

                if ($phone = data_get($data, 'phone')) {
                    $q->where('phone', $phone);
                }

                if ($company = data_get($data, 'company')) {
                    $q->where('company', $company);
                }

                if ($uuid = data_get($data, 'uuid')) {
                    $q->where('uuid', $uuid);
                }

                if ($orderCode = data_get($data, 'order_code')) {
                    $q->where('order_code', $orderCode);
                }

                if ($orderStatus = data_get($data, 'order_status')) {
                    $q->where('order_status', $orderStatus);
                }

                $orderStatuses = data_get($data, 'order_statuses', []);

                if (!empty($orderStatuses)) {
                    $q->whereIn('order_status', $orderStatuses);
                }

                $paymentStatuses = data_get($data, 'payment_status', []);

                if (!empty($paymentStatuses)) {
                    $q->whereIn('payment_status', $paymentStatuses);
                }
            })
            ->search([]);

        return $result;
    }

    public function searchByUser($userId, $data = [])
    {
        /** @var User */
        $user = $this->userService->show($userId);

        $result = $this->orderRepository
            ->with(['orderItems', 'orderItems.inventory'])
            ->scopeQuery(function($q) use ($user, $data) {
                $q->where('user_id', $user->getKey())
                    ->where('currency_code', $user->currency_code);
            });

        $result = $result->search([], null, ['*'], false);

        return $result;
    }

    public function update($attributes = [], $id)
    {
        return $this->orderRepository->update($attributes, $id);
    }

    public function findByUserAndCode($userId, $orderCode)
    {
        $result = $this->orderRepository
            ->with(['depositTransaction', 'paymentOption', 'cart', 'orderItems', 'orderItems.inventory'])
            ->scopeQuery(function($q) use ($userId, $orderCode) {
                $q->where('user_id', $userId)
                    ->where('order_code', $orderCode);
            })
            ->first();

        return $result;
    }

    public function show($id, $data = [])
    {
        return $this->orderRepository
            ->with(data_get($data, 'with', []))
            ->findOrFail($id);
    }

    public function createFromCartByUser($user, $cart, $paymentOption, $shippingRate, $createdBy, $meta = [])
    {
        /** @var Cart */
        $cart = $this->cartService->show($cart);

        /** @var User */
        $user = $this->userService->show($user);

        /** @var ShippingRate */
        $shippingRate = $this->shippingRateService->show($shippingRate);

        /** @var PaymentOption */
        $paymentOption = $this->paymentOptionService->show($paymentOption);

        $orderCode = $this->generateOrderCode();

        if ($user->currency_code != $cart->currency_code) {
            throw new BusinessLogicException('[Payment] Invalid Cart.', ExceptionCode::INVALID_CART);
        }

        if ($user->currency_code != $paymentOption->currency_code) {
            throw new BusinessLogicException('[Payment] Invalid User.', ExceptionCode::INVALID_USER);
        }

        $grandTotal = Money::make($cart->total_price, $cart->currency_code)->plus($shippingRate->rate);

        $meta = array_merge($meta, [
            'payment_option_id' => $paymentOption->getKey(),
            'shipping_rate_id'  => $shippingRate->getKey()
        ]);

        $data = array_merge(
            [
                'order_code' => $orderCode,
                'uuid' => (string) Str::uuid(),
                'user_id' => $user->getKey(),
                'currency_code' => $cart->currency_code,
                'total_item' => $cart->total_item,
                'total_price' => $cart->total_price,
                'total_quantity' => $cart->total_quantity,
                'grand_total' => (string) $grandTotal,
                'payment_status' => PaymentStatusEnum::PENDING,
                'order_status' => OrderStatusEnum::WAITING_FOR_PAYMENT,
                'is_sent_invoice_to_user' => 0,
            ],
            BaseModel::getMorphProperty('created_by', $createdBy),
            BaseModel::getMorphProperty('updated_by', $createdBy),
            $meta
        );

        $order = $this->orderRepository->create($data);

        return $order;
    }

    public function generateOrderCode()
    {
        $orderCode = mt_rand(1000, 99999999);

        while($this->orderRepository->exists(['order_code' => $orderCode])) {
            $orderCode = mt_rand(1000, 99999999);
        }

        return $orderCode;
    }

    public function statisticOrderStatus($status, $data = [])
    {
        return $this->orderRepository
            ->scopeQuery(function ($q) use ($status, $data) {
                $q->where('order_status', $status);

                if (! empty(data_get($data, 'month'))) {
                    $q->whereMonth('updated_at', data_get($data, 'month'));
                }

                if (! empty($data['year'])) {
                    $q->whereYear('updated_at', data_get($data, 'year'));
                }
            })
            ->count();
    }

    public function declined($id, $data = [])
    {
        $cacheKey = OrderCacheKeyEnum::getOrderCacheKey(OrderCacheKeyEnum::ORDER, $id);

        return Cache::lock($cacheKey, OrderCacheKeyEnum::TTL)
            ->block(OrderCacheKeyEnum::MAXIMUM_WAIT, function() use ($id, $data) {
                /** @var Order */
                $order = $this->show($id);

                if (! $order->isProcessing()) {
                    throw new BusinessLogicException("Unable to update order #{$order->id}.", ExceptionCode::INVALID_ORDER);
                }

                $updateResource = array_merge(['order_status' => OrderStatusEnum::DECLINED], [
                    'log' => array_merge($order->log ?? [], Arr::wrap(data_get($data, 'log', [])))
                ], $data);

                $order = $this->orderRepository->update($updateResource, $order);

                OrderDeclined::dispatch($order);

                return $order;
            });
    }

    public function approvePayment($id, $data = [])
    {
        $cacheKey = OrderCacheKeyEnum::getOrderCacheKey(OrderCacheKeyEnum::ORDER, $id);

        return Cache::lock($cacheKey, OrderCacheKeyEnum::TTL)
            ->block(OrderCacheKeyEnum::MAXIMUM_WAIT, function() use ($id, $data) {
                /** @var Order */
                $order = $this->show($id);

                if (! $order->isPendingPayment()) {
                    throw new BusinessLogicException("Unable to update order payment #{$order->id}.", ExceptionCode::INVALID_ORDER);
                }

                $updateResource = array_merge(['payment_status' => PaymentStatusEnum::APPROVED], $data);

                $order = $this->orderRepository->update($updateResource, $order);

                OrderPaymentApproved::dispatch($order);

                return $order;
            });
    }
}
