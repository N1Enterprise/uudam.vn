<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Support\Facades\Route;

class CategoryResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'category_group_id' => $this->category_group_id,
            'primary_image' => $this->primary_image,
            'status' => $this->status,
            'status_name' => $this->status_name,
            'order' => $this->order,
            'featured' => $this->featured,
            'featured_name' => $this->featured_name,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'category_group' => $this->whenLoaded('categoryGroup', function() {
                return [
                    'id' => $this->categoryGroup->id,
                    'name' => $this->categoryGroup->name,
                ];
            })
        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        $updatePermission = $this->getPermissionByAction('update');

        return array_filter([
            'actions' => array_filter([
                'update' => $updatePermission ? Route::findByName('bo.web.categories.edit', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
