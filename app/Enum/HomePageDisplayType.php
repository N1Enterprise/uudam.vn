<?php

namespace App\Enum;

class HomePageDisplayType extends BaseEnum
{
    public const PRODUCT = 1;
    public const COLLECTION = 2;

    public static function all(): array
    {
        return [
            self::PRODUCT,
            self::COLLECTION,
        ];
    }
}
