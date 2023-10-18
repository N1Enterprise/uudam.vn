<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Support\Facades\Route;

class PageResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'custom_redirect_url' => $this->custom_redirect_url,
            'title' => $this->title,
            'display_type' => $this->display_type,
            'display_type_name' => $this->display_type_name,
            'order' => $this->order,
            'status' => $this->status,
            'status_name' => $this->status_name,
            'has_contact_form' => $this->has_contact_form,
            'has_contact_form_name' => $this->has_contact_form_name,
            'description' => $this->description,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->whenLoaded('createdBy', function() {
                return new CreatedByResource($this->createdBy);
            }),
            'updated_by' => $this->whenLoaded('updatedBy', function() {
                return new UpdatedByResource($this->updatedBy);
            }),
        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        $updatePermission = $this->getPermissionByAction('update');
        $deletePermission = $this->getPermissionByAction('delete');

        return array_filter([
            'actions' => array_filter([
                'update' => $updatePermission ? Route::findByName('bo.web.pages.edit', ['id' => $this->getKey()]) : null,
                'delete' => $deletePermission ? Route::findByName('bo.web.pages.delete', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
