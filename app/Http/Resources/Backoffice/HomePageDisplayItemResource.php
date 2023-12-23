<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Support\Facades\Route;

class HomePageDisplayItemResource extends BaseJsonResource
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
            'type' => $this->type,
            'type_name' => $this->type_name,
            'linked_items' => $this->linked_items,
            'group_id' => $this->group_id,
            'group' => $this->whenLoaded('group', function() {
                return optional($this->group)->only(['id', 'name']);
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        $updatePermission = $this->getPermissionByAction('update');

        return array_filter([
            'actions' => array_filter([
                'update' => $updatePermission ? Route::findByName('bo.web.home-page-display-items.edit', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
