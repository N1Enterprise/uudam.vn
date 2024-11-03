<?php

namespace App\Http\Resources\Backoffice;

use App\Enum\PaymentOptionTypeEnum;
use Illuminate\Support\Facades\Route;

class PaymentOptionResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'name' => $this->name,
            'logo' => image($this->logo),
            'type' => $this->type,
            'type_name' => $this->type_name,
            'payment_provider' => PaymentOptionTypeEnum::isThirdParty($this->type) ? $this->whenLoaded('paymentProvider', function() {
                return optional($this->paymentProvider)->only(['id', 'name']);
            }) : null,
            'currency' => $this->currency,
            'status' => $this->status,
            'created_at' => $this->created_at_localized,
            'updated_at' => $this->updated_at_localized,
            'status_name' => $this->status_name,
            'type_name' => $this->type_name,
            'display_on_frontend' => $this->display_on_frontend,
            'order' => $this->order,

        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        $updatePermission = $this->getPermissionByAction('update');

        return array_filter([
            'actions' => array_filter([
                'update' => $updatePermission ? Route::findByName('bo.web.payment-options.edit', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
