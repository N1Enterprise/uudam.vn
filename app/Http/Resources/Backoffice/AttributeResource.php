<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Support\Facades\Route;

class AttributeResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'name' => $this->name,
            'attribute_type' => $this->attribute_type,
            'attribute_type_name' => $this->attribute_type_name,
            'order' => $this->order,
            'status' => $this->status,
            'status_name' => $this->status_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'categories' => $this->whenLoaded('categories', function() {
                return optional($this->categories)->map(function($category) {
                    return $category->only(['id', 'name']);
                });
            }, []),
        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        $updatePermission = $this->getPermissionByAction('update');

        return array_filter([
            'actions' => array_filter([
                'update' => $updatePermission ? Route::findByName('bo.web.attributes.edit', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
