<?php

namespace App\Enum;

class CurrencyTypeEnum extends BaseEnum
{
    public const FIAT = 1;
    public const CRYPTO = 2;

    public static $labels = [
        self::FIAT => 'Fiat Money',
        self::CRYPTO => 'Cryptocurrency',
    ];

    public static function all(): array
    {
        return [
            self::FIAT,
            self::CRYPTO,
        ];
    }
}
