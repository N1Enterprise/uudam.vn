<?php

namespace App\Enum;

class TransactionTypeEnum extends BaseEnum
{
    public const DEPOSIT = 1;
    public const WITHDRAW = 2;

    public static function all(): array
    {
        return [
            self::DEPOSIT,
            self::WITHDRAW,
        ];
    }
}
