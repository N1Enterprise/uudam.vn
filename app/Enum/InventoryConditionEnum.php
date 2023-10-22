<?php

namespace App\Enum;

class InventoryConditionEnum extends BaseEnum
{
    public const NEW = 1;
    public const USED = 2;

    public static function all(): array
    {
        return [
            self::NEW,
            self::USED,
        ];
    }
}
