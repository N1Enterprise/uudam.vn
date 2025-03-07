<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Support\Facades\Route;

class CollectionResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'name' => $this->name,
            'primary_image' => $this->primary_image,
            'cover_image' => $this->cover_image,
            'cta_label' => $this->cta_label,
            'description' => $this->description,
            'display_on_frontend' => $this->display_on_frontend,
            'display_on_frontend_name' => $this->display_on_frontend_name,
            'allow_frontend_search' => $this->allow_frontend_search,
            'allow_frontend_search_name' => $this->allow_frontend_search_name,
            'status' => $this->status,
            'status_name' => $this->status_name,
            'linked_inventories' => $this->linked_inventories,
            'linked_featured_inventories' => $this->linked_featured_inventories,
            'order' => $this->order,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        $updatePermission = $this->getPermissionByAction('update');
        $deletePermission = $this->getPermissionByAction('delete');

        return array_filter([
            'actions' => array_filter([
                'update' => $updatePermission ? Route::findByName('bo.web.collections.edit', ['id' => $this->getKey()]) : null,
                'delete' => $deletePermission ? Route::findByName('bo.web.collections.delete', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
