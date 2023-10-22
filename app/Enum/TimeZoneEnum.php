<?php

namespace App\Enum;

class TimeZoneEnum extends BaseEnum
{
    public const UTC_OFFSET_KEY = 'utc_offset';
    public const UTC_OFFSET_TIMEOUT = 2628000;

    public static function all(): array
    {
        return [
            self::UTC_OFFSET_KEY,
            self::UTC_OFFSET_TIMEOUT,
        ];
    }
}
