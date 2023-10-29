<?php

namespace App\Http\Resources\Frontend;

use App\Http\Resources\Frontend\BaseJsonResource;

class LinkedInventoryResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'sale_price' => format_price($this->sale_price),
            'offer_price' => format_price($this->offer_price),
            'image' => $this->image,
            'product' => $this->whenLoaded('product', function() {
                return optional($this->product)->only(['id', 'primary_image']);
            })
        ];
    }
}
