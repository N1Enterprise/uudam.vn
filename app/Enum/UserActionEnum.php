<?php

namespace App\Enum;

class UserActionEnum extends BaseEnum
{
    public const ACTIVE = 1;
    public const DEACTIVATE = 2;

    public static function all(): array
    {
        return [
            self::ACTIVE,
            self::DEACTIVATE,
        ];
    }

    public static function type(): array
    {
        return [
            'ACTIVE',
            'DEACTIVATE',
        ];
    }
}
