<?php

namespace App\Http\Resources\Frontend;

use App\Http\Resources\Frontend\BaseJsonResource;

class UserAddressResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'email'         => $this->email,
            'phone'         => $this->phone,
            'province_code' => $this->province_code,
            'district_code' => $this->district_code,
            'ward_code'     => $this->ward_code,
            'address_line'  => $this->address_line,
            'is_default'    => $this->is_default,
            'province'      => $this->whenLoaded('province', function() {
                return optional($this->province)->only(['code', 'name', 'full_name']);
            }),
            'district'       => $this->whenLoaded('district', function() {
                return optional($this->province)->only(['code', 'name', 'full_name']);
            }),
            'ward'          => $this->whenLoaded('ward', function() {
                return optional($this->province)->only(['code', 'name', 'full_name']);
            }),
        ];
    }
}
