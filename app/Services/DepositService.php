<?php

namespace App\Services;

use App\Common\Cache;
use App\Enum\DepositStatusEnum;
use App\Enum\TransactionCacheKeyEnum;
use App\Events\Deposit\DepositApproved;
use App\Events\Deposit\DepositCancelled;
use App\Events\Deposit\DepositDeclined;
use App\Events\Deposit\Deposited;
use App\Exceptions\BusinessLogicException;
use App\Exceptions\ExceptionCode;
use App\Models\BaseModel;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use App\Models\PaymentOption;
use App\Models\User;
use App\Payment\BasePaymentIntegration;
use App\Payment\PaymentIntegrationService;
use App\Models\Order;

class DepositService extends BaseService
{
    public $depositTransactionService;
    public $paymentOptionService;
    public $userWalletService;
    public $userService;
    public $paymentIntegrationService;
    public $orderService;

    public function __construct(
        DepositTransactionService $depositTransactionService,
        PaymentOptionService $paymentOptionService,
        UserWalletService $userWalletService,
        UserService $userService,
        PaymentIntegrationService $paymentIntegrationService,
        OrderService $orderService
    ) {
        $this->depositTransactionService = $depositTransactionService;
        $this->paymentOptionService = $paymentOptionService;
        $this->userWalletService = $userWalletService;
        $this->userService = $userService;
        $this->paymentIntegrationService = $paymentIntegrationService;
        $this->orderService = $orderService;
    }

    public function deposit($userId, $amount, $paymentOptionId, $createdBy, $data = [])
    {
        /** @var User */
        $user = $this->userService->show($userId);

        /** @var PaymentOption */
        $paymentOption = $this->paymentOptionService->show($paymentOptionId);

        if ($paymentOption->currency_code != $user->currency_code) {
            throw new BusinessLogicException('[Deposit] Invalid User.', ExceptionCode::INVALID_USER);
        }

        $paymentIntegrationService = null;

        if ($paymentOption->isThirdParty()) {
            $paymentIntegrationService = $this->paymentIntegrationService->resolveServiceClassByPaymentOption($paymentOption);
        }

        $order = $this->orderService->find(data_get($data, 'order_id'));

        $depositTransaction = DB::transaction(function() use ($user, $order, $amount, $paymentOption, $createdBy, $data, $paymentIntegrationService) {
            $currencyCode = data_get($data, 'currency_code');
            $uniqueKey    = data_get($data, 'unique_key');
            $log          = data_get($data, 'log');
            $referenceId  = data_get($data, 'reference_id');
            $orderId      = BaseModel::getModelKey($order);

            $meta = [
                'footprint'    => data_get($data, 'footprint', []),
                'unique_key'   => $uniqueKey,
                'log'          => $log,
                'reference_id' => $referenceId,
                'order_id'     => $orderId
            ];

            if ($paymentOption->isThirdParty() && $paymentIntegrationService instanceof BasePaymentIntegration) {
                $meta['provider_payload'] = $paymentIntegrationService->parsePayload(array_merge($data, [
                    'user' => $user
                ]));
            }

            $bankTransferInfo = [];

            $depositTransaction = $this->depositTransactionService->createByUser(
                $user,
                $amount,
                $currencyCode,
                $paymentOption,
                $createdBy,
                $bankTransferInfo,
                $meta
            );

            $order = $depositTransaction->order;

            if ($order instanceof Order) {
                $depositTransaction->update([
                    'log' => array_merge(data_get($depositTransaction, 'log', []), [
                        'order_describing_payment_content' => $order->getDescribingPaymentContent(),
                    ])
                ]);
            }

            $paymentOption = $depositTransaction->paymentOption;

            if ($paymentOption && $paymentOption->isThirdParty() && ! data_get($data, 'only_internal_transaction', false)) {
                if ($paymentIntegrationService instanceof BasePaymentIntegration) {
                    if (! $paymentIntegrationService->shouldHandleTransactionAfterCommit()) {
                        return $paymentIntegrationService->handleTransaction($depositTransaction);
                    }
                }
            }

            return $depositTransaction;
        });

        $freshDepositTransaction = $depositTransaction->fresh();

        Deposited::dispatch($freshDepositTransaction);

        return $freshDepositTransaction;
    }

    public function approve($transactionId, $data = [], $quietly = false)
    {
        $cacheKey = TransactionCacheKeyEnum::getTransactionCacheKey(TransactionCacheKeyEnum::DEPOSIT_TRANSACTION, BaseModel::getModelKey($transactionId));

        $transaction = Cache::lock($cacheKey, TransactionCacheKeyEnum::TTL)
            ->block(TransactionCacheKeyEnum::MAXIMUM_WAIT, function() use ($transactionId, $data, $quietly) {
                $transaction = $this->depositTransactionService->show($transactionId);

                if (! $transaction->isPending()) {
                    throw new BusinessLogicException('Unable to update this transaction.', ExceptionCode::INVALID_TRANSACTION);
                }

                $transaction = DB::transaction(function() use ($transaction, &$approvedTimes, $data, $quietly) {
                    $approvedTimes = $this->depositTransactionService->getApprovedTimesForUser($transaction->user_id);

                    $updateParams = array_merge(['status' => DepositStatusEnum::APPROVED], $data);

                    ++$approvedTimes;

                    $transaction = $this->depositTransactionService->update(array_merge($updateParams, [
                        'approved_index' => $approvedTimes,
                    ]), $transaction->getKey(), $quietly);

                    DepositApproved::dispatch($transaction);

                    return $transaction;
                });

                return $transaction;
            });

        return $transaction;
    }

    public function decline($transactionId, $data = [])
    {
        $cacheKey = TransactionCacheKeyEnum::getTransactionCacheKey(TransactionCacheKeyEnum::DEPOSIT_TRANSACTION, BaseModel::getModelKey($transactionId));

        $transaction = Cache::lock($cacheKey, TransactionCacheKeyEnum::TTL)
            ->block(TransactionCacheKeyEnum::MAXIMUM_WAIT, function() use ($transactionId, $data) {
                $transaction = $this->depositTransactionService->show($transactionId);

                if (! $transaction->isPending()) {
                    throw new BusinessLogicException("Unable to update transaction #{$transaction->id}.", ExceptionCode::INVALID_TRANSACTION);
                }

                $updateResource = array_merge(['status' => DepositStatusEnum::DECLINED], $data);

                $transaction = $this->depositTransactionService->update($updateResource, $transaction);

                DepositDeclined::dispatch($transaction);

                return $transaction;
            });

        return $transaction;
    }

    public function cancel($transactionId, $data = [])
    {
        $cacheKey = TransactionCacheKeyEnum::getTransactionCacheKey(TransactionCacheKeyEnum::DEPOSIT_TRANSACTION, BaseModel::getModelKey($transactionId));

        $transaction = Cache::lock($cacheKey, TransactionCacheKeyEnum::TTL)
            ->block(TransactionCacheKeyEnum::MAXIMUM_WAIT, function () use ($transactionId, $data) {
                $transaction = $this->depositTransactionService->show($transactionId);

                if (! $transaction->isPending()) {
                    throw new BusinessLogicException('Unable to update this transaction.', ExceptionCode::INVALID_TRANSACTION);
                }

                $updateParams = array_merge(['status' => DepositStatusEnum::FAILED], $data);

                $transaction = $this->depositTransactionService->update($updateParams, $transaction);

                DepositCancelled::dispatch($transaction);

                return $transaction;
            });

        return $transaction;
    }
}
