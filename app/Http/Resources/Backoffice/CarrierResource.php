<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Support\Facades\Route;

class CarrierResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'name' => $this->name,
            'logo' => $this->logo,
            'email' => $this->email,
            'phone' => $this->phone,
            'params' => $this->params,
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
                'update' => $updatePermission ? Route::findByName('bo.web.carriers.edit', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
