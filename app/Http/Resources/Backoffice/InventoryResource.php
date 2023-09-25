<?php

namespace App\Http\Resources\Backoffice;

use App\Common\Money;
use Illuminate\Support\Facades\Route;

class InventoryResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'product_id' => $this->product_id,
            'condition' => $this->condition,
            'condition_name' => $this->condition_name,
            'condition_note' => $this->condition_note,
            'status' => $this->status,
            'status_name' => $this->status_name,
            'sku' => $this->sku,
            'status' => $this->status_name,
            'description' => $this->description,
            'key_features' => $this->key_features,
            'purchase_price' => Money::format($this->purchase_price),
            'sale_price' => Money::format($this->sale_price),
            'offer_price' => Money::format($this->offer_price),
            'offer_start' => $this->offer_start,
            'offer_end' => $this->offer_end,
            'stock_quantity' => $this->stock_quantity,
            'min_order_quantity' => $this->min_order_quantity,
            'available_from' => $this->available_from,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'image' => $this->image,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'product' => $this->whenLoaded('product', function() {
                return optional($this->product)->only('id', 'name', 'primary_image', 'type_name');
            }),
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
                'update' => $updatePermission ? Route::findByName('bo.web.inventories.edit', ['id' => $this->getKey()]) : null,
                'delete' => $deletePermission ? Route::findByName('bo.web.inventories.delete', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
