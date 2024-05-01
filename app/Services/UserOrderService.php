<?php

namespace App\Services;

use App\Enum\DepositStatusEnum;
use App\Enum\PaymentStatusEnum;
use App\Enum\ShippingRateTypeEnum;
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
use App\Vendors\Localization\Province;
use App\Vendors\Localization\District;
use App\Vendors\Localization\Ward;
use App\Models\Province as ProvinceEntity;
use App\Models\District as DistrictEntity;
use App\Models\ShippingRate;
use App\Models\ShippingZone;
use App\Models\Ward as WardEntity;
use App\Vendors\Localization\Money;

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
    public $inventoryService;
    public $providerShippingFeeHistoryService;
    public $shippingZoneService;

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
        AddressService $addressService,
        InventoryService $inventoryService,
        ProviderShippingFeeHistoryService $providerShippingFeeHistoryService,
        ShippingZoneService $shippingZoneService
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
        $this->inventoryService = $inventoryService;
        $this->providerShippingFeeHistoryService = $providerShippingFeeHistoryService;
        $this->shippingZoneService = $shippingZoneService;
    }

    public function orderByAdmin($userId, $inventoryData = [], $paymentOptionId, $shippingOptionId, $addressInfo = [], $createdBy, $data = [])
    {
        /** @var PaymentOption */
        $paymentOption = $this->paymentOptionService->show($paymentOptionId);

        /** @var ShippingOption */
        $shippingOption = $this->shippingOptionService->show($shippingOptionId);

        /** @var User */
        $user = $this->userService->show($userId);

        /** @var ProvinceEntity */
        $province = Province::make()->find(data_get($addressInfo, 'province_code'));

        /** @var DistrictEntity */
        $district = District::make()->find(data_get($addressInfo, 'district_code'));

        /** @var WardEntity */
        $ward = Ward::make()->find(data_get($addressInfo, 'ward_code'));

        $data['currency_code'] = $user->currency_code;

        return DB::transaction(function() use ($user, $paymentOption, $shippingOption, $inventoryData, $province, $district, $ward, $data, $createdBy) {
            $collectionInvs = collect($inventoryData)->keyBy('inventory_id');
            $inventories = $this->inventoryService->getAvailableByIds($collectionInvs->keys()->toArray());

            $items = $inventories->map(function($inventory) use ($collectionInvs) {
                return [
                    'inventory_id' => $inventory->id,
                    'final_price' => $inventory->final_price,
                    'quantity' => data_get($collectionInvs, [$inventory->id, 'quantity'], 0),
                    'inventory' => $inventory
                ];
            });

            /** @var Order */
            $order = $this->orderService->createFromInventoryDataByUser($user, $items, $paymentOption, $shippingOption, $createdBy, $data);

            $this->orderItemService->createListFormInventoryDataByUser($user, $items, $order, $data);

            $totalWeight = ShippingCartHelper::getTotalWeightFromItems($items ?? []);

            $shippingZone = null;
            $shippingRate = null;
            $estimatedTransportFee = 0;

            if ($shippingOption->isShippingZone()) {
                $shippingZone = $this->shippingZoneService->getByProvinceAndDistrict($province->code, $district->code);
                $shippingRate = empty($shippingZone) ? null : $this->shippingRateService->getByShippingZone($shippingOption, ShippingRateTypeEnum::WEIGHT, $totalWeight);
                $estimatedTransportFee = empty($shippingRate) ? 0 : $shippingRate->rate;
            }

            $userOrderShippingHistory = $this->userOrderShippingHistoryService->create([
                'user_id' => BaseModel::getModelKey($user),
                'order_id' => BaseModel::getModelKey($order),
                'shipping_option_id' => $shippingOption->id,
                'shipping_provider_id' => $shippingOption->shipping_provider_id,
                'shipping_zone_id' => $shippingZone instanceof ShippingZone ? BaseModel::getModelKey($shippingZone) : null,
                'shipping_rate_id' => $shippingRate instanceof ShippingRate ? BaseModel::getModelKey($shippingRate) : null,
                'status' => UserOrderShippingHistoryStatusEnum::PENDING,
                'total_weight' => $totalWeight,
                'estimated_transport_fee' => $estimatedTransportFee,
                'total_invoice_amount' => (string) Money::make($order->grand_total, $user->currency_code)->plus($estimatedTransportFee),
                'provider_shipping_fee_history_id' => null
            ]);

            $order->total_weight = $userOrderShippingHistory->total_weight;
            $order->grand_total  = $userOrderShippingHistory->total_invoice_amount;

            $order->fill([
                'fullname' => data_get($data, 'fullname'),
                'email' => data_get($data, 'email'),
                'phone' => data_get($data, 'phone'),
                'company' => data_get($data, 'company'),
                'postal_code' => data_get($data, 'postal_code'),
                'address_line' => data_get($data, 'address_line'),
                'province_name' => $province->full_name,
                'district_name' => $district->full_name,
                'ward_name' => $ward->ward_name,
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

            OrderCreated::dispatch($order);

            return $order;
        });
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
            DepositStatusEnum::WAIT_FOR_CONFIRMATION => PaymentStatusEnum::PENDING,
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

    public function cancelByUser($user, $orderCode, $data = [])
    {
        $user = $this->userService->show($user);
        $order = $this->orderService->findByUserAndCode(get_model_key($user), $orderCode);

        if (empty($order)) {
            throw new BusinessLogicException("Invalid user order.");
        }

        $meta = [
            'log' => vsprintf('[CANCEL_BY_USER with code %s] %s', [
                data_get($data, 'reason'),
                data_get($data, 'content'),
            ]),
        ];

        return $this->orderService->cancel($order, $meta);
    }
}
