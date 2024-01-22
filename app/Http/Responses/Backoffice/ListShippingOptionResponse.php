<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListShippingOptionResponseContract;
use App\Http\Resources\Backoffice\ShippingOptionResource;

class ListShippingOptionResponse extends BaseResponse implements ListShippingOptionResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(ShippingOptionResource::pagination($this->resource), $this->status, $this->headers);
    }
}
