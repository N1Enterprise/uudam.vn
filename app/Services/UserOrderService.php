<?php

namespace App\Services;

use App\Enum\OrderStatusEnum;
use App\Events\Order\OrderCreated;
use App\Events\Order\OrderUpdated;
use App\Exceptions\BusinessLogicException;
use App\Exceptions\ExceptionCode;
use App\Repositories\Contracts\OrderRepositoryContract;
use App\Services\BaseService;
use App\Models\PaymentOption;
use App\Models\ShippingRate;
use App\Models\User;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\DepositTransaction;
use App\Payment\PaymentIntegrationService;
use Illuminate\Support\Arr;
use App\Models\ShippingOption;

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
        DepositService $depositService
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
    }

    public function order($userId, $cartUuid, $paymentOptionId, $shippingOptionId, $createdBy, $data = [])
    {
        /** @var PaymentOption */
        $paymentOption = $this->paymentOptionService->show($paymentOptionId);

        /** @var ShippingOption */
        $shippingOption = $this->shippingOptionService->show($shippingOptionId);

        /** @var Cart */
        $cart = $this->cartService->findByUser($userId, ['uuid' => $cartUuid]);
        dd($cartUuid);

        /** @var User */
        $user = $this->userService->show($userId);

        if (empty($cart)) {
            throw new BusinessLogicException('[Payment] Invalid Cart.', ExceptionCode::INVALID_CART);
        }

        if ($cart->order_id) {
            throw new BusinessLogicException('[Payment] Invalid Order.', ExceptionCode::INVALID_CART);
        }

        return DB::transaction(function() use ($user, $paymentOption, $shippingOption, $cart, $data, $createdBy) {
            /** @var Order */
            $order = $this->orderService->createFromCartByUser($user, $cart, $paymentOption, $shippingOption, $createdBy, $data);

            $this->orderItemService->createListFormCartByUser($user, $cart, $order, $data);

            $bankTransferInfo = $paymentOption->isLocalBank() ? [
                'account_name' => data_get($data, 'account_name'),
                'account_number' => data_get($data, 'account_number'),
                'bank_slip_document' => data_get($data, 'bank_slip_document'),
            ] : null;

            $deposit = $this->depositService->deposit(
                $user,
                $order->grand_total,
                $paymentOption,
                $user,
                $data
            );

            // /** @var DepositTransaction */
            // $depositTransaction = $this->depositTransactionService->createByUser(
            //     $user,
            //     $order->grand_total,
            //     $order->currency_code,
            //     $paymentOption,
            //     $order,
            //     $createdBy,
            //     $bankTransferInfo,
            //     [],
            // );

            // dd($depositTransaction);

            // $depositTransaction = $depositTransaction->fresh();

            // $order->deposit_transaction_id = $depositTransaction->getKey();

            // if ($paymentOption->isCashOnDelivery()) {
            //     $order->order_status = OrderStatusEnum::PROCESSING;
            //     $order->save();
            // }

            // $order = $order->fresh();

            // $this->cartService->purchased($cart, $order);

            // OrderCreated::dispatch($order);

            // return $order;
        });
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
}
