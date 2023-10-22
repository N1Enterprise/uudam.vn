<?php

namespace App\Enum;

class UserStatusEnum extends BaseEnum
{
    public const INACTIVE = 0;
    public const ACTIVE = 1;

    public static function all(): array
    {
        return [
            self::ACTIVE,
            self::INACTIVE,
        ];
    }
}
