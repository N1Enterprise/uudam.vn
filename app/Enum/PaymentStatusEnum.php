<?php

namespace App\Enum;

class PaymentStatusEnum extends BaseEnum
{
    public const DECLINED = 0;
    public const PENDING = 1;
    public const APPROVED = 2;
    public const CANCELED = 3;
    public const FAILED = 4;

    public static $labels = [
        self::DECLINED => 'Thanh toán bị từ chối',
        self::PENDING => 'Thanh toán đang duyệt',
        self::APPROVED => 'Thanh toán thành công',
        self::CANCELED => 'Thanh toán đã bị huỷ',
        self::FAILED => 'Thanh toán không thanh công',
    ];

    public static function all(): array
    {
        return [
            self::DECLINED,
            self::PENDING,
            self::APPROVED,
            self::CANCELED,
            self::FAILED,
        ];
    }
}
