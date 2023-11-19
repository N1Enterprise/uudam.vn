<?php

namespace App\Http\Resources\Frontend;

use App\Http\Resources\Frontend\BaseJsonResource;

class CartItemResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'total_price' => $this->total_price,
        ];
    }
}
