<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Support\Facades\Route;

class DepositTransactionResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'amount' => $this->toMoney('amount')->format(),
            'status' => $this->status,
            'status_name' => $this->status_name,
            'provider_response' => $this->provider_response,
            'note' => $this->note,
            'reference_id' => $this->reference_id,
            'currency_code' => $this->currency_code,
            'user_id' => $this->user_id,
            'payment_option_id' => $this->payment_option_id,
            'order_id' => $this->order_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'order' => $this->whenLoaded('order', function() {
                return array_merge(optional($this->order)->only(['id', 'order_code', 'order_status_name', 'order_status']), [
                    'edit_link' => route('bo.web.orders.edit', $this->order->id)
                ]);
            }),
            'user' => $this->whenLoaded('user', function() {
                return array_merge(optional($this->user)->only(['id', 'name']), [
                    'edit_link' => route('bo.web.users.edit', $this->user->id)
                ]);
            }),
            'payment_option' => $this->whenLoaded('paymentOption', function() {
                return array_merge(optional($this->paymentOption)->only(['id', 'name']), [
                    'edit_link' => route('bo.web.payment-options.edit', $this->paymentOption->id)
                ]);
            }),
            'created_by' => $this->whenLoaded('createdBy', function() {
                return new CreatedByResource($this->createdBy);
            }),
            'updated_by' => $this->whenLoaded('updatedBy', function() {
                return new UpdatedByResource($this->updatedBy);
            }),
        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        $updatePermission = $this->getPermissionByAction('update');

        return array_filter([
            'actions' => array_filter([
                'show' => $updatePermission ? Route::findByName('bo.web.deposit-transactions.edit', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
