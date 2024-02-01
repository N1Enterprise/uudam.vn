<?php

namespace App\Enum;

class ActivationStatusEnum extends BaseEnum
{
    public const INACTIVE = 0;
    public const ACTIVE = 1;

    public static $labels = [
        self::INACTIVE => 'Không hoạt động',
        self::ACTIVE => 'Hoạt động',
    ];

    public static function all(): array
    {
        return [
            self::INACTIVE,
            self::ACTIVE,
        ];
    }

    public static function isActive($key)
    {
        return $key == self::ACTIVE;
    }
}
