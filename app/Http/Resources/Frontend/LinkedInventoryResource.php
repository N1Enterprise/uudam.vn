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
            'has_offer_price' => $this->has_offer_price,
            'final_price' => format_price($this->final_price),
            'sub_price' => format_price($this->sub_price),
            'discount_percent' => $this->has_offer_price ? get_percent($this->final_price, $this->sub_price) : 0,
            'price_for_saving' => format_price((float) $this->sub_price - (float) $this->final_price),
            'final_sold_count' => $this->final_sold_count,
            'image' => $this->image,
            'border_image' => $this->border_image,
            'product' => $this->whenLoaded('product', function() {
                $positiveReviewCount = $this->final_sold_count > 0 && $this->final_sold_count >= $this->product->positive_review_count
                    ? $this->product->positive_review_count
                    : null;

                return array_merge(optional($this->product)->only(['id', 'branch']), $positiveReviewCount ? [
                    'positive_review_count' => $positiveReviewCount
                ] : []);
            })
        ];
    }
}
