<?php

namespace App\Http\Resources\Frontend;

use App\Enum\PaymentOptionTypeEnum;
use App\Http\Resources\Frontend\BaseJsonResource;

class UserOrderResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return [
            'order_code' => $this->order_code,
            'order_status_name' => $this->order_status_name,
            'grand_total' => $this->grand_total,
            'end_of_redirect_at' => [
                'success' => route('fe.web.user.checkout.payment.success', $this->order_code),
                'failed'  => route('fe.web.user.checkout.payment.failure', $this->order_code),
            ],
            'paying_confirmed' => optional($this->paymentOption)->type == PaymentOptionTypeEnum::CASH_ON_DELIVERY,
            'payment' => [
                'data' => '',
                'redirect_output' => [
                    'url' => '',
                    'container' => 'redirect'
                ]
            ],
        ];
    }
}
