<?php

namespace App\Http\Resources\Backoffice;

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
            'display_on_frontend' => $this->display_on_frontend,
            'display_on_frontend_name' => $this->display_on_frontend_name,
            'allow_frontend_search' => $this->allow_frontend_search,
            'allow_frontend_search_name' => $this->allow_frontend_search_name,
            'sku' => $this->sku,
            'description' => $this->description,
            'key_features' => $this->key_features,
            'purchase_price' => format_price($this->purchase_price),
            'sale_price' => format_price($this->sale_price),
            'offer_price' => format_price($this->offer_price),
            'offer_start' => $this->offer_start,
            'offer_end' => $this->offer_end,
            'stock_quantity' => $this->stock_quantity,
            'min_order_quantity' => $this->min_order_quantity,
            'discount_percent' => $this->has_offer_price ? get_percent($this->final_price, $this->sub_price) : 0,
            'price_for_saving' => format_price((float) $this->sub_price - (float) $this->final_price),
            'init_sold_count' => $this->init_sold_count,
            'sold_count' => $this->sold_count,
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
                'update'  => $updatePermission ? Route::findByName('bo.web.inventories.edit', ['id' => $this->getKey()]) : null,
                'delete'  => $deletePermission ? Route::findByName('bo.web.inventories.delete', ['id' => $this->getKey()]) : null,
                'fe_link' => Route::findByName('fe.web.products.index', $this->slug),
            ]),
        ]);
    }
}
