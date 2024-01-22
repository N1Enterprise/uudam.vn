<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Support\Facades\Route;

class ShippingOptionResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'type_name' => $this->type_name,
            'logo' => $this->logo,
            'params' => $this->params,
            'status' => $this->status,
            'status_name' => $this->status_name,
            'shipping_provider_id' => $this->shipping_provider_id,
            'expanded_content' => $this->expanded_content,
            'supported_countries' => $this->supported_countries,
            'supported_provinces' => $this->supported_provinces,
            'display_on_frontend' => $this->display_on_frontend,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'order' => $this->order,
            'shipping_provider' => $this->whenLoaded('shippingProvider', function() {
                return new ShippingProviderResource($this->shippingProvider);
            }),
        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        $updatePermission = $this->getPermissionByAction('update');

        return array_filter([
            'actions' => array_filter([
                'update' => $updatePermission ? Route::findByName('bo.web.shipping-options.edit', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
