<?php

namespace App\Http\Resources\Backoffice;

class CartItemResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'cart_id' => $this->cart_id,
            'cart' => $this->whenLoaded('cart', function() {
                return optional($this->cart)->only(['id']);
            }),
            'uuid' => $this->uuid,
            'inventory_id' => $this->inventory_id,
            'note' => $this->note,
            'has_combo' => $this->has_combo,
            'quantity' => $this->quantity,
            'currency_code' => $this->currency_code,
            'price' => $this->toMoney('price')->format(),
            'total_price' => $this->toMoney('total_price')->format(),
            'user_id' => $this->user_id,
            'user' => $this->whenLoaded('user', function() {
                return optional($this->user)->only(['id', 'name', 'email']);
            }),
            'inventory' => $this->whenLoaded('inventory', function() {
                return array_merge(
                    optional($this->inventory)->only(['id', 'title', 'image']),
                    [
                        'edit' => route('bo.web.inventories.edit', $this->inventory->id)
                    ]
                );
            }),
            'status' => $this->status,
            'status_name' => $this->status_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
