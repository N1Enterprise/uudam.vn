<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Support\Facades\Route;

class VideoCategoryResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'order' => $this->order,
            'status' => $this->status,
            'status_name' => $this->status_name,
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
                'update'  => $updatePermission ? Route::findByName('bo.web.video-categories.edit', ['id' => $this->getKey()]) : null,
                'delete'  => $deletePermission ? Route::findByName('bo.web.video-categories.delete', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
