<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Support\Facades\Route;

class HomePageDisplayOrderResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'name' => $this->name,
            'order' => $this->order,
            'status' => $this->status,
            'status_name' => $this->status_name,
            'display_on_frontend' => $this->display_on_frontend,
            'display_on_frontend_name' => $this->display_on_frontend_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        $updatePermission = $this->getPermissionByAction('update');

        return array_filter([
            'actions' => array_filter([
                'update' => $updatePermission ? Route::findByName('bo.web.home-page-display-orders.edit', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
