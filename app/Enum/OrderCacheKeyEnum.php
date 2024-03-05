<?php

namespace App\Enum;

class OrderCacheKeyEnum extends BaseEnum
{
    public const ORDER = 'order';
    public const ORDER_PAYMENT = 'order_payment';
    public const TTL = 20;
    public const MAXIMUM_WAIT = 20;

    public static function all(): array
    {
        return [
            self::ORDER,
            self::ORDER_PAYMENT
        ];
    }

    public static function getOrderCacheKey($key, $orderId, $prefix = '_')
    {
        return $key.$prefix.$orderId;
    }
}
