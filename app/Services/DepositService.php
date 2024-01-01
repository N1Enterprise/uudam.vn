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

class DepositService extends BaseService
{
    public $depositTransactionService;
    public $paymentOptionService;
    public $userWalletService;

    public function __construct(
        DepositTransactionService $depositTransactionService,
        PaymentOptionService $paymentOptionService,
        UserWalletService $userWalletService
    ) {
        $this->depositTransactionService = $depositTransactionService;
        $this->paymentOptionService = $paymentOptionService;
        $this->userWalletService = $userWalletService;
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
        logger('DepositService:approve 1', [
            'transaction_id' => $transactionId,
            'data' => $data,
        ]);

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

                    logger('DepositService:approve 2', [
                        'transaction' => $transaction
                    ]);

                    DepositApproved::dispatch($transaction);

                    return $transaction;
                });

                return $transaction;
            });

        return $transaction;
    }
}
