<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Support\Facades\Route;

class ProductReviewResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'user_name' => $this->user_name,
            'user_phone' => $this->user_phone,
            'user_email' => $this->user_email,
            'rating_type' => $this->rating_type,
            'content' => $this->content,
            'status' => $this->status,
            'status_name' => $this->status_name,
            'product_id' => $this->product_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
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
                'update' => $updatePermission ? Route::findByName('bo.web.product-reviews.edit', ['id' => $this->getKey()]) : null,
                'delete' => $deletePermission ? Route::findByName('bo.web.product-reviews.delete', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
