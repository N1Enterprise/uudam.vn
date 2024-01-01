<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Support\Facades\Route;

class ProductResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'code' => $this->code,
            'branch' => $this->branch,
            'type' => $this->type,
            'type_name' => $this->type_name,
            'status' => $this->status,
            'status_name' => $this->status_name,
            'primary_image' => $this->primary_image,
            'media' => $this->media,
            'created_by' => new CreatedByResource($this->createdBy),
            'updated_by' => new UpdatedByResource($this->updatedBy),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        $updatePermission = $this->getPermissionByAction('update');

        return array_filter([
            'actions' => array_filter([
                'update' => $updatePermission ? Route::findByName('bo.web.products.edit', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
