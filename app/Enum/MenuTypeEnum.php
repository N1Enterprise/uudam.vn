<?php

namespace App\Enum;

class MenuTypeEnum extends BaseEnum
{
    public const COLLECTION = 1;
    public const INVENTORY = 2;
    public const POST = 3;

    public static function all(): array
    {
        return [
            self::COLLECTION,
            self::INVENTORY,
            self::POST,
        ];
    }
}
