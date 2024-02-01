<?php

namespace App\Http\Resources\Frontend;

use App\Http\Resources\Frontend\BaseJsonResource;

class UserCheckoutShippingFeeHistoryResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return [
            'user_id' => $this->user_id,
            'address_id' => $this->address_id,
            'currency_code' => $this->currency_code,
            'total_item' => $this->total_item,
            'total_quantity' => $this->total_quantity,

            'total_price' => $this->total_price,
            'total_price_formatted' => format_price($this->total_price),
            'transport_fee' => $this->transport_fee,
            'transport_fee_formatted' => format_price($this->transport_fee),
            'total_estimated_amount' => $this->total_estimated_amount,
            'total_estimated_amount_formatted' => format_price($this->total_estimated_amount)
        ];
    }
}
