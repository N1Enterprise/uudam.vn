<?php

namespace App\Services;

use App\Enum\DepositStatusEnum;
use App\Models\BaseModel;
use App\Repositories\Contracts\DepositTransactionRepositoryContract;
use App\Services\BaseService;
use App\Vendors\Localization\Money;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\PaymentOption;
use App\Models\User;
use App\Models\Order;

class DepositTransactionService extends BaseService
{
    public $depositTransactionRepository;
    public $paymentOptionService;
    public $orderService;
    public $userService;

    public function __construct(
        DepositTransactionRepositoryContract $depositTransactionRepository,
        PaymentOptionService $paymentOptionService,
        OrderService $orderService,
        UserService $userService
    ) {
        $this->depositTransactionRepository = $depositTransactionRepository;
        $this->paymentOptionService = $paymentOptionService;
        $this->orderService = $orderService;
        $this->userService = $userService;
    }

    public function createByUser(
        $user,
        $amount,
        $currencyCode,
        $paymentOptionId,
        $orderId,
        $createdBy,
        $bankTransferInfo = [],
        $meta = []
    ) {
        /** @var PaymentOption */
        $paymentOption = $this->paymentOptionService->show($paymentOptionId);

        /** @var Order */
        $order = $this->orderService->show($orderId);

        /** @var User */
        $user = $this->userService->show($user);

        $amount = Money::make($amount, $currencyCode);

        if (! $createdBy instanceof Model) {
            throw new \Exception('Invalid Created By.');
        }

        $bankTransferInfo = array_filter($bankTransferInfo ?? []);

        $depositTransaction = $this->depositTransactionRepository->create(
            array_merge([
                'user_id' => $user->getKey(),
                'uuid' => (string) Str::uuid(),
                'amount' => (string) $amount,
                'status' => DepositStatusEnum::PENDING,
                'payment_option_id' => $paymentOption->getKey(),
                'order_id' => $order->getKey(),
                'currency_code' => $currencyCode,
            ],
            array_filter(['bank_transfer_info' => $bankTransferInfo]),
            BaseModel::getMorphProperty('created_by', $createdBy),
            BaseModel::getMorphProperty('updated_by', $createdBy),
            $meta
        ));

        return $depositTransaction;
    }
}
