<?php

namespace App\Http\Resources\Frontend;

use App\Http\Resources\Frontend\BaseJsonResource;

class PaymentProviderResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'params' => $this->params,
            'payment_type' => $this->payment_type,
            'payment_type_name' => $this->payment_type_name,
            'status' => $this->status,
            'status_name' => $this->status_name,
        ];
    }
}
