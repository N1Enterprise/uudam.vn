<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListShippingRateResponseContract;
use App\Http\Resources\Backoffice\ShippingRateResource;

class ListShippingRateResponse extends BaseResponse implements ListShippingRateResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(ShippingRateResource::pagination($this->resource), $this->status, $this->headers);
    }
}
