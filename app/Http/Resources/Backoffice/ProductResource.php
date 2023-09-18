<?php

namespace App\Http\Resources\Backoffice;

use App\Enum\ActivationStatusEnum;
use Illuminate\Support\Facades\Route;

class ProductResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'name' => $this->name,
        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        $updatePermission = $this->getPermissionByAction('update');

        return array_filter([
            'actions' => array_filter([
                'update' => $updatePermission ? Route::findByName('bo.web.products.edit', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
