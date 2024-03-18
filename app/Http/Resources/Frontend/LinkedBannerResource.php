<?php

namespace App\Http\Resources\Frontend;

use App\Http\Resources\Frontend\BaseJsonResource;

class LinkedBannerResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'label' => $this->label,
            'cta_label' => $this->cta_label,
            'redirect_url' => $this->redirect_url,
            'order' => $this->order,
            'desktop_image' => $this->desktop_image,
            'mobile_image' => $this->mobile_image,
            'color' => $this->color,
        ];
    }
}
