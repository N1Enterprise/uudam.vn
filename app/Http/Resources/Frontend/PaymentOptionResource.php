<?php

namespace App\Http\Resources\Frontend;

use App\Http\Resources\Frontend\BaseJsonResource;

class PaymentOptionResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'type_name' => $this->type_name,
            'min_amount' => $this->toMoney('min_amount')->format(),
            'max_amount' => $this->toMoney('max_amount')->format(),
            'currency_code' => $this->currency_code,
            'params' => $this->params,
            'payment_provider' => $this->when($this->whenLoaded('paymentProvider', true, false), function() {
                return PaymentProviderResource::make($this->paymentProvider);
            })
        ];
    }
}
