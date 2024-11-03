<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Support\Facades\Route;

class OrderResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'uuid' => $this->uuid,
            'order_code' => $this->order_code,
            'user_id' => $this->user_id,
            'user' => $this->whenLoaded('user', function() {
                return optional($this->user)->only(['id', 'name']);
            }),
            'currency_code' => $this->currency_code,
            'fullname' => $this->fullname,
            'email' => $this->email,
            'phone' => $this->phone,
            'company' => $this->company,
            'country_code' => $this->country_code,
            'address_line' => $this->address_line,
            'city_name' => $this->city_name,
            'postal_code' => $this->postal_code,
            'shipping_rate_id' => $this->shipping_rate_id,
            'shipping_rate' => $this->whenLoaded('shippingRate', function() {
                return optional($this->shippingRate)->only(['id', 'name']);
            }),
            'payment_option_id' => $this->payment_option_id,
            'payment_option' => $this->whenLoaded('paymentOption', function() {
                return optional($this->paymentOption)->only(['id', 'name']);
            }),
            'total_item' => $this->total_item,
            'total_quantity' => $this->total_quantity,
            'taxrate' => $this->taxrate,
            'shipping_weight' => $this->shipping_weight,
            'total_price' => $this->toMoney('total_price')->format(),
            'taxes' => $this->taxes,
            'coupon_id' => $this->coupon_id,
            'promotion_id' => $this->promotion_id,
            'grand_total' => $this->toMoney('grand_total')->format(),
            'deposit_transaction_id' => $this->deposit_transaction_id,
            'shipping_date' => $this->shipping_date,
            'delivery_date' => $this->delivery_date,
            'payment_status' => $this->payment_status,
            'payment_status_name' => $this->payment_status_name,
            'order_status' => $this->order_status,
            'order_status_name' => $this->order_status_name,
            'is_sent_invoice_to_user' => $this->is_sent_invoice_to_user,
            'admin_note' => $this->admin_note,
            'user_note' => $this->user_note,
            'retry_order_times' => $this->retry_order_times,
            'order_channel' => $this->order_channel,
            'created_by' => $this->whenLoaded('createdBy', function() {
                return new CreatedByResource($this->createdBy);
            }),
            'updated_by' => $this->whenLoaded('updatedBy', function() {
                return new UpdatedByResource($this->updatedBy);
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
                'update' => $managePermission ? Route::findByName('bo.web.orders.edit', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
