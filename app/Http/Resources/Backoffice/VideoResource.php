<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Support\Facades\Route;

class VideoResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'order' => $this->order,
            'thumbnail' => $this->thumbnail,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'source_url' => $this->source_url,
            'status' => $this->status,
            'status_name' => $this->status_name,
            'type' => $this->type,
            'type_name' => $this->type_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'display_on_frontend' => $this->display_on_frontend,
            'display_on_frontend_name' => $this->display_on_frontend_name,
            'video_category_id' => $this->video_category_id,
            'created_by' => $this->whenLoaded('createdBy', function() {
                return new CreatedByResource($this->createdBy);
            }),
            'updated_by' => $this->whenLoaded('updatedBy', function() {
                return new UpdatedByResource($this->updatedBy);
            }),
            'category' => $this->whenLoaded('category', function() {
                return new VideoCategoryResource($this->category);
            }),
        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        $updatePermission = $this->getPermissionByAction('update');
        $deletePermission = $this->getPermissionByAction('delete');

        return array_filter([
            'actions' => array_filter([
                'update' => $updatePermission ? Route::findByName('bo.web.videos.edit', ['id' => $this->getKey()]) : null,
                'delete' => $deletePermission ? Route::findByName('bo.web.videos.delete', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
