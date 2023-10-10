<?php

namespace App\Enum;

class MenuTypeEnum extends BaseEnum
{
    public const NORMAL = 1;
    public const INVENTORY = 2;
    public const POST = 3;

    public static function all(): array
    {
        return [
            self::NORMAL,
            self::INVENTORY,
            self::POST,
        ];
    }
}
