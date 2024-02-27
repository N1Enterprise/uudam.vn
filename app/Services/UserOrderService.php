<?php

namespace App\Services;

use App\Enum\DepositStatusEnum;
use App\Enum\PaymentStatusEnum;
use App\Enum\UserOrderShippingHistoryStatusEnum;
use App\Events\Order\OrderCreated;
use App\Events\Order\OrderUpdated;
use App\Exceptions\BusinessLogicException;
use App\Exceptions\ExceptionCode;
use App\Models\BaseModel;
use App\Repositories\Contracts\OrderRepositoryContract;
use App\Services\BaseService;
use App\Models\PaymentOption;
use App\Models\User;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\DepositTransaction;
use App\Payment\PaymentIntegrationService;
use Illuminate\Support\Arr;
use App\Models\ShippingOption;
use App\Shipping\Helpers\ShippingCartHelper;
use App\Models\Address;

class UserOrderService extends BaseService
{
    public $orderRepository;
    public $paymentOptionService;
    public $shippingRateService;
    public $cartService;
    public $userService;
    public $orderService;
    public $depositTransactionService;
    public $orderItemService;
    public $paymentIntegrationService;
    public $shippingOptionService;
    public $depositService;
    public $userOrderShippingHistoryService;
    public $userCheckoutService;
    public $addressService;

    public function __construct(
        OrderRepositoryContract $orderRepository,
        PaymentOptionService $paymentOptionService,
        ShippingRateService $shippingRateService,
        CartService $cartService,
        UserService $userService,
        OrderService $orderService,
        OrderItemService $orderItemService,
        DepositTransactionService $depositTransactionService,
        PaymentIntegrationService $paymentIntegrationService,
        ShippingOptionService $shippingOptionService,
        DepositService $depositService,
        UserOrderShippingHistoryService $userOrderShippingHistoryService,
        UserCheckoutService $userCheckoutService,
        AddressService $addressService
    ) {
        $this->orderRepository = $orderRepository;
        $this->paymentOptionService = $paymentOptionService;
        $this->shippingRateService = $shippingRateService;
        $this->cartService = $cartService;
        $this->userService = $userService;
        $this->orderService = $orderService;
        $this->depositTransactionService = $depositTransactionService;
        $this->orderItemService = $orderItemService;
        $this->paymentIntegrationService = $paymentIntegrationService;
        $this->shippingOptionService = $shippingOptionService;
        $this->depositService = $depositService;
        $this->userOrderShippingHistoryService = $userOrderShippingHistoryService;
        $this->userCheckoutService = $userCheckoutService;
        $this->addressService = $addressService;
    }

    public function order($userId, $cartUuid, $paymentOptionId, $shippingOptionId, $addressId, $createdBy, $data = [])
    {
        /** @var PaymentOption */
        $paymentOption = $this->paymentOptionService->show($paymentOptionId);

        /** @var ShippingOption */
        $shippingOption = $this->shippingOptionService->show($shippingOptionId);

        /** @var Cart */
        $cart = $this->cartService->findByUser($userId, ['uuid' => $cartUuid]);

        /** @var Address */
        $address = $this->addressService->show($addressId);

        /** @var User */
        $user = $this->userService->show($userId);

        if (empty($cart)) {
            throw new BusinessLogicException('[Payment] Invalid Cart.', ExceptionCode::INVALID_CART);
        }

        if ($cart->order_id) {
            throw new BusinessLogicException('[Payment] Invalid Order.', ExceptionCode::INVALID_CART);
        }

        $data['currency_code'] = $user->currency_code;

        return DB::transaction(function() use ($user, $paymentOption, $shippingOption, $cart, $data, $address, $createdBy) {
            /** @var Order */
            $order = $this->orderService->createFromCartByUser($user, $cart, $paymentOption, $shippingOption, $createdBy, $data);

            $this->orderItemService->createListFormCartByUser($user, $cart, $order, $data);

            $history = $this->userCheckoutService->handleCartShippingFeeByShippingOption($cart, $shippingOption, $address);

            $userOrderShippingHistory = $this->userOrderShippingHistoryService->create([
                'user_id' => BaseModel::getModelKey($user),
                'order_id' => BaseModel::getModelKey($order),
                'shipping_option_id' => data_get($history, 'shipping_option_id'),
                'shipping_provider_id' => data_get($history, 'shipping_provider_id'),
                'shipping_zone_id' => data_get($history, 'shipping_zone_id'),
                'shipping_rate_id' => data_get($history, 'shipping_rate_id'),
                'status' => UserOrderShippingHistoryStatusEnum::PENDING,
                'total_weight' => ShippingCartHelper::getTotalWeightFromItems($cart->availableItems ?? []),
                'estimated_transport_fee' => data_get($history, 'transport_fee'),
                'total_invoice_amount' => data_get($history, 'total_estimated_amount'),
                'provider_shipping_fee_history_id' => data_get($history, 'id')
            ]);

            $order->total_weight = $userOrderShippingHistory->total_weight;
            $order->grand_total  = $userOrderShippingHistory->total_invoice_amount;

            $order->fill([
                'fullname' => $user->name,
                'email' => $address->email,
                'phone' => $address->phone,
                'province_name' => data_get($address, ['province', 'full_name']),
                'district_name' => data_get($address, ['district', 'full_name']),
                'ward_name' => data_get($address, ['ward', 'full_name']),
                'address_line' => data_get($address, ['address_line']),
            ]);

            /** @var DepositTransaction */
            $deposit = $this->depositService->deposit(
                $user,
                $order->grand_total,
                $paymentOption,
                $user,
                array_merge($data, ['order_id' => $order->getKey()])
            );

            $order->payment_status = $this->parseDepositStatusToOrderPaymentStatus($deposit->status);
            $order->deposit_transaction_id = $deposit->getKey();

            $order->save();

            $order = $order->fresh();

            $this->cartService->purchased($cart, $order);

            OrderCreated::dispatch($order);

            return $order;
        });
    }

    /**
     * @return Order
     */
    public function fillOrderUserAddressInfo(Order $order, User $user, Address $address)
    {
        $order->fullname = $user->name;
        $order->email = $user->email;
        $order->email = $user->email;

        return $order;
    }

    public function reorderPaymentByOrderCode($userId, $orderCode, $data = [])
    {
        /** @var Order */
        $order = $this->orderService->findByUserAndCode($userId, $orderCode);

        /** @var User */
        $user = $this->userService->show($userId);

        if ($order->isSucceed()) {
            throw new BusinessLogicException('[Payment] Invalid Order.', ExceptionCode::INVALID_ORDER);
        }

        if ($user->currency_code != $order->currency_code) {
            throw new BusinessLogicException('[Payment] Invalid User.', ExceptionCode::INVALID_USER);
        }

        return DB::transaction(function() use ($order, $data) {
            $retryOrderTimes = ($order->retry_order_times ?? 0) + 1;

            $updateData = array_merge(
                Arr::only($data, ['shipping_rate_id', 'payment_option_id']),
                [
                    'retry_order_times' => $retryOrderTimes
                ]
            );

            $order = $this->orderService->update($updateData, $order->getKey());

            OrderUpdated::dispatch($order);

            return $order;
        });
    }

    /**
     * @param mixed $depositStatus
     * @param bool $throwIfNotFound
     * @return array
     */
    public function parseDepositStatusToOrderPaymentStatus($depositStatus, $throwIfNotFound = true)
    {
        $mappers = [
            DepositStatusEnum::DECLINED => PaymentStatusEnum::DECLINED,
            DepositStatusEnum::PENDING  => PaymentStatusEnum::PENDING,
            DepositStatusEnum::APPROVED => PaymentStatusEnum::APPROVED,
            DepositStatusEnum::CANCELED => PaymentStatusEnum::CANCELED,
            DepositStatusEnum::FAILED   => PaymentStatusEnum::FAILED,
        ];

        $status = $mappers[$depositStatus] ?? null;

        if ($status === null && $throwIfNotFound) {
            throw new BusinessLogicException("Invalid payment status.");
        }

        return $status;
    }
}
