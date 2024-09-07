<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Support\Facades\Route;

class PostResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'image' => $this->image,
            'description' => $this->description,
            'post_at' => $this->post_at,
            'post_category_id' => $this->post_category_id,
            'order' => $this->order,
            'status' => $this->status,
            'status_name' => $this->status_name,
            'display_on_frontend' => $this->display_on_frontend,
            'display_on_frontend_name' => $this->display_on_frontend_name,
            'code' => $this->code,
            'allow_frontend_search' => $this->allow_frontend_search,
            'allow_frontend_search_name' => $this->allow_frontend_search_name,
            'meta' => $this->meta,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'author' => $this->author,
            'post_category' => $this->whenLoaded('postCategory', function() {
                return optional($this->postCategory)->only(['id', 'name']);
            }),
            'created_by' => $this->whenLoaded('createdBy', function() {
                return new CreatedByResource($this->createdBy);
            }),
            'updated_by' => $this->whenLoaded('updatedBy', function() {
                return new CreatedByResource($this->updatedBy);
            })
        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        $updatePermission = $this->getPermissionByAction('update');
        $deletePermission = $this->getPermissionByAction('delete');

        return array_filter([
            'actions' => array_filter([
                'update' => $updatePermission ? Route::findByName('bo.web.posts.edit', ['id' => $this->getKey()]) : null,
                'delete' => $deletePermission ? Route::findByName('bo.web.posts.delete', ['id' => $this->getKey()]) : null,
                'fe_link' => Route::findByName('fe.web.posts.index', ['slug' => $this->slug, 'code' => $this->code]),
            ]),
        ]);
    }
}
