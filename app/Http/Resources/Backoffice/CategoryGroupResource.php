<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Support\Facades\Route;

class CategoryGroupResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'name' => $this->name,
            'order' => $this->order,
            'status' => $this->status,
            'primary_image' => $this->primary_image,
            'status_name' => $this->status_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'categories' => $this->whenLoaded('categories', function() {
                return CategoryResource::collection($this->categories);
            }),
        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        $updatePermission = $this->getPermissionByAction('update');

        return array_filter([
            'actions' => array_filter([
                'update' => $updatePermission ? Route::findByName('bo.web.category-groups.edit', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
