<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Support\Facades\Route;

class ProductComboResource extends BaseJsonResource
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
            'unit' => $this->unit,
            'stock_quantity' => $this->stock_quantity,
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
                'update' => $updatePermission ? Route::findByName('bo.web.product-combos.edit', ['id' => $this->getKey()]) : null,
                'delete' => $deletePermission ? Route::findByName('bo.web.product-combos.delete', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
