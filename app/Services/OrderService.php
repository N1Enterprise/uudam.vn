<?php

namespace App\Services;

use App\Common\Cache;
use App\Enum\OrderCacheKeyEnum;
use App\Enum\OrderStatusEnum;
use App\Enum\PaymentStatusEnum;
use App\Events\Order\OrderCanceled;
use App\Events\Order\OrderCompleted;
use App\Events\Order\OrderDelivered;
use App\Events\Order\OrderRefuned;
use App\Exceptions\BusinessLogicException;
use App\Exceptions\ExceptionCode;
use App\Models\BaseModel;
use App\Repositories\Contracts\OrderRepositoryContract;
use App\Services\BaseService;
use App\Models\PaymentOption;
use App\Models\ShippingOption;
use App\Models\User;
use App\Models\Cart;
use App\Vendors\Localization\Money;
use Illuminate\Support\Str;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderService extends BaseService
{
    public $orderRepository;
    public $paymentOptionService;
    public $shippingOptionService;
    public $cartService;
    public $userService;

    public function __construct(
        OrderRepositoryContract $orderRepository,
        PaymentOptionService $paymentOptionService,
        ShippingOptionService $shippingOptionService,
        CartService $cartService,
        UserService $userService
    ) {
        $this->orderRepository = $orderRepository;
        $this->paymentOptionService = $paymentOptionService;
        $this->shippingOptionService = $shippingOptionService;
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

    public function find($id, $data = [])
    {
        return $this->orderRepository
            ->with(data_get($data, 'with', []))
            ->find($id);
    }

    public function createFromCartByUser($user, $cart, $paymentOption, $shippingOption, $createdBy, $data = [])
    {
        /** @var Cart */
        $cart = $this->cartService->show($cart);

        /** @var User */
        $user = $this->userService->show($user);

        /** @var ShippingOption */
        $shippingOption = $this->shippingOptionService->show($shippingOption);

        /** @var PaymentOption */
        $paymentOption = $this->paymentOptionService->show($paymentOption);

        $orderCode = $this->generateOrderCode();

        if ($user->currency_code != $cart->currency_code) {
            throw new BusinessLogicException('[Payment] Invalid Cart.', ExceptionCode::INVALID_CART);
        }

        if ($user->currency_code != $paymentOption->currency_code) {
            throw new BusinessLogicException('[Payment] Invalid User.', ExceptionCode::INVALID_USER);
        }

        $grandTotal = Money::make($cart->total_price, $cart->currency_code);

        $meta = [
            'footprint' => data_get($data, 'footprint', []),
        ];

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
                'payment_option_id'  => $paymentOption->getKey(),
                'shipping_option_id' => $shippingOption->getKey()
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

    public function delivery($orderId, $data = [])
    {
        $cacheKey = OrderCacheKeyEnum::getOrderCacheKey(OrderCacheKeyEnum::ORDER, BaseModel::getModelKey($orderId));

        return Cache::lock($cacheKey, OrderCacheKeyEnum::TTL)->block(OrderCacheKeyEnum::MAXIMUM_WAIT, function() use ($orderId, $data) {
            /** @var Order */
            $order = $this->show($orderId);

            if (! $order->canDelivery()) {
                throw new BusinessLogicException('Unable to update this order.', ExceptionCode::INVALID_ORDER);
            }

            return DB::transaction(function() use ($order, $data) {
                $order = $this->orderRepository->update([
                    'order_status' => OrderStatusEnum::DELIVERY,
                    'admin_note'   => data_get($data, 'admin_note', '')
                ], $order->getKey());

                OrderDelivered::dispatch($order);

                return $order;
            });
        });
    }

    public function complete($orderId, $data = [])
    {
        $cacheKey = OrderCacheKeyEnum::getOrderCacheKey(OrderCacheKeyEnum::ORDER, BaseModel::getModelKey($orderId));

        return Cache::lock($cacheKey, OrderCacheKeyEnum::TTL)->block(OrderCacheKeyEnum::MAXIMUM_WAIT, function() use ($orderId, $data) {
            /** @var Order */
            $order = $this->show($orderId);

            if (! $order->canComplete()) {
                throw new BusinessLogicException('Unable to update this order.', ExceptionCode::INVALID_ORDER);
            }

            return DB::transaction(function() use ($order, $data) {
                $order = $this->orderRepository->update([
                    'order_status'   => OrderStatusEnum::COMPLETED,
                    'admin_note'     => data_get($data, 'admin_note', '')
                ], $order->getKey());

                if ($order->isPendingPayment()) {
                    DepositService::make()->approve($order->deposit_transaction_id);
                }

                OrderCompleted::dispatch($order);

                return $order;
            });
        });
    }

    public function cancel($orderId, $data = [])
    {
        $cacheKey = OrderCacheKeyEnum::getOrderCacheKey(OrderCacheKeyEnum::ORDER, BaseModel::getModelKey($orderId));

        return Cache::lock($cacheKey, OrderCacheKeyEnum::TTL)->block(OrderCacheKeyEnum::MAXIMUM_WAIT, function() use ($orderId, $data) {
            /** @var Order */
            $order = $this->show($orderId);

            if (! $order->canCancel()) {
                throw new BusinessLogicException('Unable to update this order.', ExceptionCode::INVALID_ORDER);
            }

            return DB::transaction(function() use ($order, $data) {
                $order = $this->orderRepository->update([
                    'order_status' => OrderStatusEnum::CANCELED,
                    'admin_note'   => data_get($data, 'admin_note', '')
                ], $order->getKey());

                OrderCanceled::dispatch($order);

                return $order;
            });
        });
    }

    public function refund($orderId, $data = [])
    {
        $cacheKey = OrderCacheKeyEnum::getOrderCacheKey(OrderCacheKeyEnum::ORDER, BaseModel::getModelKey($orderId));

        return Cache::lock($cacheKey, OrderCacheKeyEnum::TTL)->block(OrderCacheKeyEnum::MAXIMUM_WAIT, function() use ($orderId, $data) {
            /** @var Order */
            $order = $this->show($orderId);

            if (! $order->canRefund()) {
                throw new BusinessLogicException('Unable to update this order.', ExceptionCode::INVALID_ORDER);
            }

            return DB::transaction(function() use ($order, $data) {
                $order = $this->orderRepository->update([
                    'order_status' => OrderStatusEnum::REFUNDED,
                    'admin_note'   => data_get($data, 'admin_note', '')
                ], $order->getKey());

                OrderRefuned::dispatch($order);

                return $order;
            });
        });
    }
}
