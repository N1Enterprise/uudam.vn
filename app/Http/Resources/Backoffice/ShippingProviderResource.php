<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Support\Facades\Route;

class ShippingProviderResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'params' => $this->params,
            'status' => $this->status,
            'status_name' => $this->status_name,
            'shipping_zones' => $this->shipping_zones,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        $updatePermission = $this->getPermissionByAction('update');

        return array_filter([
            'actions' => array_filter([
                'update' => $updatePermission ? Route::findByName('bo.web.shipping-providers.edit', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
