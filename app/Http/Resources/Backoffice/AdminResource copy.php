<?php

namespace App\Http\Resources\Backoffice;

use App\Enum\ActivationStatusEnum;
use Illuminate\Support\Facades\Route;

class AdminResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->getRoleNames(),
            'status' => $this->status,
            'status_name' => ActivationStatusEnum::findConstantLabel($this->status),
            'created_at' => $this->created_at_localized,
            'last_login_at' => $this->last_login_at_localized,
        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        $updatePermission = $this->getPermissionByAction('update');

        return array_filter([
            'actions' => array_filter([
                'update' => $updatePermission ? Route::findByName('bo.web.admins.edit', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
