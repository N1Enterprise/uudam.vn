<?php

namespace App\Enum;

class OrderStatusEnum extends BaseEnum
{
    public const DECLINED = 0;
    public const WAITING_FOR_PAYMENT = 1;
    public const PAYMENT_ERROR = 2;
    public const PROCESSING = 3;
    public const DELIVERY = 4;
    public const COMPLETED = 5;
    public const CANCELED = 6;
    public const REFUNDED = 7;

    public static $labels = [
        self::WAITING_FOR_PAYMENT => 'Chờ thanh toán',
        self::PAYMENT_ERROR => 'Thanh toán không thành công',
        self::PROCESSING => 'Đang xử lí',
        self::DELIVERY => 'Đang vận chuyển',
        self::COMPLETED => 'Đã hoàn thành',
        self::CANCELED => 'Đã huỷ',
        self::REFUNDED => 'Hoàn tiền',
    ];

    public static function all(): array
    {
        return [
            self::DECLINED,
            self::WAITING_FOR_PAYMENT,
            self::PAYMENT_ERROR,
            self::PROCESSING,
            self::DELIVERY,
            self::COMPLETED,
            self::CANCELED,
            self::REFUNDED,
        ];
    }

    public static function findConstantLabelVn($key) {
        $mappers = [
            self::WAITING_FOR_PAYMENT => 'Chờ thanh toán',
            self::PAYMENT_ERROR => 'Thanh toán không thành công',
            self::PROCESSING => 'Đang xử lí',
            self::DELIVERY => 'Đang vận chuyển',
            self::COMPLETED => 'Đã hoàn thành',
            self::CANCELED => 'Đã huỷ',
            self::REFUNDED => 'Hoàn tiền',
        ];

        return $mappers[$key] ?? '';
    }
}
