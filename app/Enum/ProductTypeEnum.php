<?php

namespace App\Enum;

class ProductTypeEnum extends BaseEnum
{
    public const SIMPLE = 1;
    public const VARIABLE = 2;

    public static function all(): array
    {
        return [
            self::SIMPLE,
            self::VARIABLE,
        ];
    }
}
