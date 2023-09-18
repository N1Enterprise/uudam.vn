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
            'code' => $this->code,
            'slug' => $this->slug,
            'branch' => $this->branch,
            'min_amount' => $this->min_amount,
            'min_amount' => $this->max_amount,
            'type' => $this->type,
            'type_name' => $this->type_name,
            'status' => $this->status,
            'status_name' => $this->status_name,
            'primary_image' => $this->primary_image,
            'media' => $this->media,
            'created_by' => new CreatedByResource($this->createdBy),
            'updated_by' => new UpdatedByResource($this->updatedBy),
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
