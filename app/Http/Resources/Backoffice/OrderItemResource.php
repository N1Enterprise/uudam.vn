<?php

namespace App\Http\Resources\Backoffice;

class OrderItemResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'order_id' => $this->order_id,
            'inventory_id' => $this->inventory_id,
            'item_description' => $this->item_description,
            'quantity' => $this->quantity,
            'price' => $this->toMoney('price')->format(),
            'user_id' => $this->user_id,
            'currency_code' => $this->currency_code,
            'total_price' => $this->toMoney('total_price')->format(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'order' => $this->whenLoaded('order', function() {
                return optional($this->order)->only(['id', 'order_number', 'uuid']);
            }),
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
        ], []);
    }
}
