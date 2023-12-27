<?php

namespace App\Enum;

class HomePageDisplayType extends BaseEnum
{
    public const PRODUCT = 1;
    public const COLLECTION = 2;
    public const POST = 3;
    public const BLOG = 4;

    public static function all(): array
    {
        return [
            self::PRODUCT,
            self::COLLECTION,
            self::POST,
            self::BLOG,
        ];
    }
}
