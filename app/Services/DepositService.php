<?php

namespace App\Services;

use App\Common\Cache;
use App\Enum\DepositStatusEnum;
use App\Enum\TransactionCacheKeyEnum;
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

    public function __construct(
        DepositTransactionService $depositTransactionService,
        PaymentOptionService $paymentOptionService
    ) {
        $this->depositTransactionService = $depositTransactionService;
        $this->paymentOptionService = $paymentOptionService;
    }

    public function decline($transactionId, $data = [])
    {
        $cacheKey = TransactionCacheKeyEnum::getTransactionCacheKey(TransactionCacheKeyEnum::DEPOSIT_TRANSACTION, BaseModel::getModelKey($transactionId));

        $transaction = Cache::lock($cacheKey, TransactionCacheKeyEnum::TTL)
            ->block(TransactionCacheKeyEnum::MAXIMUM_WAIT, function() use ($transactionId, $data) {
                DB::transaction(function() use ($transactionId, $data) {
                    $transaction = $this->depositTransactionService->show($transactionId);

                    if (! $transaction->isPending()) {
                        throw new BusinessLogicException("Unable to update transaction #{$transaction->id}.", ExceptionCode::INVALID_TRANSACTION);
                    }

                    $updateResource = array_merge(['status' => DepositStatusEnum::DECLINED], $data);

                    $transaction = $this->depositTransactionService->update($updateResource, $transaction);

                    DepositDeclined::dispatch($transaction);

                    return $transaction;
                });
            });

        return $transaction;
    }
}
