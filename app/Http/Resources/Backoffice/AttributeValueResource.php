<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Support\Facades\Route;

class AttributeValueResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'value' => $this->value,
            'order' => $this->order,
            'status' => $this->status,
            'status_name' => $this->status_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'attribute' => $this->whenLoaded('attribute', function() {
                return optional($this->attribute)->only(['id', 'name']);
            }),
        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        $updatePermission = $this->getPermissionByAction('update');
        $deletePermission = $this->getPermissionByAction('delete');

        return array_filter([
            'actions' => array_filter([
                'update' => $updatePermission ? Route::findByName('bo.web.attribute-values.edit', ['id' => $this->getKey()]) : null,
                'delete' => $deletePermission ? Route::findByName('bo.web.attribute-values.delete', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
