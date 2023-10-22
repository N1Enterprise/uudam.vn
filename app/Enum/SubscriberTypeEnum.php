<?php

namespace App\Enum;

class SubscriberTypeEnum extends BaseEnum
{
    public const NEWSLETTER = 1;

    public static function all(): array
    {
        return [
            self::NEWSLETTER,
        ];
    }
}
