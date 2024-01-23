<?php

namespace App\Http\Resources\Frontend;

use App\Enum\DepositStatusEnum;
use App\Enum\PaymentOptionTypeEnum;
use App\Http\Resources\Frontend\BaseJsonResource;

class UserOrderResource extends BaseJsonResource
{
    public function toArray($request)
    {
        $depositTransaction = $this->depositTransaction;

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
                'data' => [
                    'status_name' => DepositStatusEnum::findConstantLabel($depositTransaction->status),
                    'amount' => $depositTransaction->toMoney('amount')->toFloat(),
                    'currency_code' => $depositTransaction->currency_code,
                ],
                'redirect_output' => data_get($depositTransaction, 'log.provider_response_meta.redirect_output', []) ?? []
            ],
        ];
    }
}
