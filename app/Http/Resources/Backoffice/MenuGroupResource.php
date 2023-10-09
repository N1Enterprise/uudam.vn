<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Support\Facades\Route;

class MenuGroupResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        $updatePermission = $this->getPermissionByAction('update');
        $deletePermission = $this->getPermissionByAction('delete');

        return array_filter([
            'actions' => array_filter([
                'update' => $updatePermission ? Route::findByName('bo.web.menu-groups.edit', ['id' => $this->getKey()]) : null,
                'delete' => $deletePermission ? Route::findByName('bo.web.menu-groups.destroy', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
