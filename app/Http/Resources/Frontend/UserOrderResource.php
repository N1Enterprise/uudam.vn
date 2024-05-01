<?php

namespace App\Http\Resources\Frontend;

use App\Enum\DepositStatusEnum;
use App\Enum\PaymentOptionTypeEnum;
use App\Http\Resources\Frontend\BaseJsonResource;
use App\Models\DepositTransaction;

class UserOrderResource extends BaseJsonResource
{
    public function toArray($request)
    {
        $depositTransaction = $this->depositTransaction;

        if (! ($depositTransaction instanceof DepositTransaction)) {
            return;
        }

        return [
            'order_code' => $this->order_code,
            'order_status_name' => $this->order_status_name,
            'grand_total' => $this->grand_total,
            'end_of_redirect_at' => route('fe.web.user.checkout.payment.status', optional($this->cart)->uuid),
            'paying_confirmed' => optional($this->paymentOption)->type == PaymentOptionTypeEnum::NONE_AMOUNT,
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
