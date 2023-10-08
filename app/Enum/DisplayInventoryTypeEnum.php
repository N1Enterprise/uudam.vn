<?php

namespace App\Enum;

class DisplayInventoryTypeEnum extends BaseEnum
{
    public const POPULAR = 1;
    public const YOU_MAY_LIKE = 2;

    public static function all(): array
    {
        return [
            self::POPULAR,
            self::YOU_MAY_LIKE,
        ];
    }
}
