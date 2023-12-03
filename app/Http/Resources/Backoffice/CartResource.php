<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Support\Facades\Route;

class CartResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'uuid' => $this->uuid,
            'ip_address' => $this->ip_address,
            'user_id' => $this->user_id,
            'user' => $this->whenLoaded('user', function() {
                return array_merge(
                    optional($this->user)->only(['id', 'name']),
                    [ 'edit_link' => route('bo.web.users.edit', $this->user->id) ]
                );
            }),
            'currency_code' => $this->currency_code,
            'total_item' => $this->total_item,
            'total_quantity' => $this->total_quantity,
            'total_price' => $this->toMoney('total_price')->format(),
            'order_id' => $this->order_id,
            'order' => $this->whenLoaded('order', function() {
                return array_merge(
                    optional($this->order)->only(['id', 'order_code', 'order_status', 'order_status_name']),
                    [ 'edit_link' => route('bo.web.orders.edit', $this->order->id) ]
                );
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        $managePermission = $this->getPermissionByAction('manage');

        return array_filter([
            'actions' => array_filter([
                'update' => $managePermission ? Route::findByName('bo.web.carts.edit', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
