<?php

namespace App\Services;

use App\Common\Cache;
use App\Enum\DepositStatusEnum;
use App\Enum\TransactionCacheKeyEnum;
use App\Events\Deposit\DepositApproved;
use App\Events\Deposit\DepositDeclined;
use App\Exceptions\BusinessLogicException;
use App\Exceptions\ExceptionCode;
use App\Models\BaseModel;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use App\Models\PaymentOption;
use App\Models\User;
use App\Payment\PaymentIntegrationService;

class DepositService extends BaseService
{
    public $depositTransactionService;
    public $paymentOptionService;
    public $userWalletService;
    public $userService;
    public $paymentIntegrationService;

    public function __construct(
        DepositTransactionService $depositTransactionService,
        PaymentOptionService $paymentOptionService,
        UserWalletService $userWalletService,
        UserService $userService,
        PaymentIntegrationService $paymentIntegrationService
    ) {
        $this->depositTransactionService = $depositTransactionService;
        $this->paymentOptionService = $paymentOptionService;
        $this->userWalletService = $userWalletService;
        $this->userService = $userService;
        $this->paymentIntegrationService = $paymentIntegrationService;
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

        $depositTransaction = DB::transaction(function() use ($user, $amount, $paymentOption, $createdBy, $data, $paymentIntegrationService) {
            $currencyCode = data_get($data, 'currency_code');
            $uniqueKey = data_get($data, 'unique_key');
            $log = data_get($data, 'log');
            $referenceId = data_get($data, 'reference_id');

            $meta = [
                'footprint' => data_get($data, 'footprint', []),
                'unique_key' => $uniqueKey,
                'log' => $log,
                'reference_id' => $referenceId,
            ];

            dd($meta);
        });
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
}
