<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Support\Facades\Route;

class IncludedProductResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'name' => $this->name,
            'sale_price' => $this->sale_price,
            'description' => $this->description,
            'image' => $this->image,
            'status' => $this->status,
            'status_name' => $this->status_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        $updatePermission = $this->getPermissionByAction('update');
        $deletePermission = $this->getPermissionByAction('delete');

        return array_filter([
            'actions' => array_filter([
                'update' => $updatePermission ? Route::findByName('bo.web.included-products.edit', ['id' => $this->getKey()]) : null,
                'delete' => $deletePermission ? Route::findByName('bo.web.included-products.delete', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
