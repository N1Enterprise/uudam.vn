<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Support\Facades\Route;

class UserResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'username' => $this->username,
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status,
            'serialized_status' => $this->serialized_status,
            'serialized_status_name' => $this->serialized_status_name,
            'last_logged_in_at' => $this->last_logged_in_at,
            'phone_number' => $this->phone_number,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'access_channel_type' => $this->access_channel_type,
            'access_channel_type_name' => $this->access_channel_type_name,
        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        $showPermission = $this->getPermissionByAction('show');

        return array_filter([
            'actions' => array_filter([
                'show' => $showPermission ? Route::findByName('bo.web.users.edit', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
