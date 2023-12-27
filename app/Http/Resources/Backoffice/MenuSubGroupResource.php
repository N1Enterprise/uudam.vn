<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Support\Facades\Route;

class MenuSubGroupResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'name' => $this->name,
            'redirect_url' => $this->redirect_url,
            'order' => $this->order,
            'status' => $this->status,
            'status_name' => $this->status_name,
            'display_on_frontend' => $this->display_on_frontend,
            'display_on_frontend_name' => $this->display_on_frontend_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'menu_group_id' => $this->menu_group_id,
            'menu_group' => $this->whenLoaded('menuGroup', function() {
                return optional($this->menuGroup)->only(['id', 'name']);
            })
        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        $updatePermission = $this->getPermissionByAction('update');
        $deletePermission = $this->getPermissionByAction('delete');

        return array_filter([
            'actions' => array_filter([
                'update' => $updatePermission ? Route::findByName('bo.web.menu-sub-groups.edit', ['id' => $this->getKey()]) : null,
                'delete' => $deletePermission ? Route::findByName('bo.web.menu-sub-groups.delete', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
