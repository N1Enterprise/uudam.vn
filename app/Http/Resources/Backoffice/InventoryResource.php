<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Support\Facades\Route;

class InventoryResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([

        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        $updatePermission = $this->getPermissionByAction('update');
        $deletePermission = $this->getPermissionByAction('delete');

        return array_filter([
            'actions' => array_filter([
                'update' => $updatePermission ? Route::findByName('bo.web.inventories.edit', ['id' => $this->getKey()]) : null,
                'delete' => $deletePermission ? Route::findByName('bo.web.inventories.delete', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
