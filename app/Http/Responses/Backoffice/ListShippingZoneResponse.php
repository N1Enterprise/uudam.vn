<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListShippingZoneResponseContract;
use App\Http\Resources\Backoffice\ShippingZoneResource;

class ListShippingZoneResponse extends BaseResponse implements ListShippingZoneResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(ShippingZoneResource::pagination($this->resource), $this->status, $this->headers);
    }
}
