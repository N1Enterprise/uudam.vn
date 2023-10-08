<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Support\Facades\Route;

class DisplayInventoryResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'inventory_id' => $this->inventory_id,
            'type' => $this->type,
            'type_name' => $this->type_name,
            'order' => $this->order,
            'redirect_url' => $this->redirect_url,
            'status' => $this->status,
            'status_name' => $this->status_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'inventory' => $this->whenLoaded('inventory', function () {
                return optional($this->inventory)->only(['id', 'title', 'slug']);
            })
        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        $updatePermission = $this->getPermissionByAction('update');
        $deletePermission = $this->getPermissionByAction('delete');

        return array_filter([
            'actions' => array_filter([
                'update' => $updatePermission ? Route::findByName('bo.web.display-inventories.edit', ['id' => $this->getKey(), 'type' => $this->type]) : null,
                'delete' => $deletePermission ? Route::findByName('bo.web.display-inventories.delete', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
