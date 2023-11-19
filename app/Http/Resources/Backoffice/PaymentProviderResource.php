<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Support\Facades\Route;

class PaymentProviderResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'params' => $this->params,
            'payment_type' => $this->payment_type,
            'payment_type_name' => $this->payment_type_name,
            'status' => $this->status,
            'status_name' => $this->status_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        $updatePermission = $this->getPermissionByAction('update');

        return array_filter([
            'actions' => array_filter([
                'update' => $updatePermission ? Route::findByName('bo.web.payment-providers.edit', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
