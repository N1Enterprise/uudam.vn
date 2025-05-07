<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Support\Facades\Route;

class RoleResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'name' => $this->name,
            'users_count' => $this->users_count,
            'created_at' => $this->created_at_localized,
        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        $updatePermission = true;

        return array_filter([
            'actions' => array_filter([
                'update' => $updatePermission ? Route::findByName('bo.web.roles.edit', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
