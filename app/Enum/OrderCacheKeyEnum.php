<?php

namespace App\Enum;

class OrderCacheKeyEnum extends BaseEnum
{
    public const ORDER = 'order';
    public const TTL = 20;
    public const MAXIMUM_WAIT = 20;

    public static function all(): array
    {
        return [
            self::ORDER,
        ];
    }

    public static function getOrderCacheKey($key, $orderId, $prefix = '_')
    {
        return $key.$prefix.$orderId;
    }
}
