<?php

namespace App\Http\Resources\Frontend;

use App\Http\Resources\Frontend\BaseJsonResource;

class DepositTransactionResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'amount' => $this->toMoney('amount')->format(),
            'status' => $this->status,
            'reference_id' => $this->reference_id,
            'order_id' => $this->order_id,
            'currency_code' => $this->currency_code,
            'approved_index' => $this->approved_index,
            'bank_transfer_info' => $this->bank_transfer_info,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'payment_option' => new PaymentOptionResource($this->paymentOption)
        ];
    }
}
