<?php

namespace App\Http\Resources\Frontend;

use App\Http\Resources\Frontend\BaseJsonResource;

class UserCheckoutShippingFeeHistoryResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return [
            'currency_code' => $this->currency_code,
            'transport_fee' => $this->transport_fee,
            'transport_fee_formatted' => format_price($this->transport_fee),
            'total_estimated_amount' => $this->total_estimated_amount,
            'total_estimated_amount_formatted' => format_price($this->total_estimated_amount)
        ];
    }
}
