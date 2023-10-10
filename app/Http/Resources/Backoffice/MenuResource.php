<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Support\Facades\Route;

class MenuResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'name' => $this->name,
            'is_new' => $this->is_new,
            'type' => $this->type,
            'type_name' => $this->type_name,
            'inventory_id' => $this->inventory_id,
            'post_id' => $this->post_id,
            'order' => $this->order,
            'meta' => $this->meta,
            'status' => $this->status,
            'status_name' => $this->status_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'catalogs' => $this->whenLoaded('menuCatalogs', function() {
                return optional($this->menuCatalogs)->map(function($item) {
                    return optional($item)->only(['id', 'name']);
                });
            }),
            'inventory' => $this->whenLoaded('inventory', function() {
                return optional($this->inventory)->only(['id', 'title']);
            }),
            'post' => $this->whenLoaded('post', function() {
                return optional($this->post)->only(['id', 'name']);
            }),
        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        $updatePermission = $this->getPermissionByAction('update');
        $deletePermission = $this->getPermissionByAction('delete');

        return array_filter([
            'actions' => array_filter([
                'update' => $updatePermission ? Route::findByName('bo.web.menus.edit', ['id' => $this->getKey()]) : null,
                'delete' => $deletePermission ? Route::findByName('bo.web.menus.delete', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
