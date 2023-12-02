<?php

namespace App\Enum;

class TransactionCacheKeyEnum extends BaseEnum
{
    public const DEPOSIT_TRANSACTION = 'deposit_transaction';
    public const TTL = 20;
    public const MAXIMUM_WAIT = 20;

    public static function all(): array
    {
        return [
            self::DEPOSIT_TRANSACTION,
        ];
    }

    public static function getTransactionCacheKey($key, $transactionId, $prefix = '_')
    {
        return $key.$prefix.$transactionId;
    }
}
