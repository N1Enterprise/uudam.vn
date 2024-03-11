<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListAvailableShippingOptionResponseContract;
use App\Http\Resources\Backoffice\ShippingOptionResource;

class ListAvailableShippingOptionResponse extends BaseResponse implements ListAvailableShippingOptionResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(ShippingOptionResource::collection($this->resource), $this->status, $this->headers);
    }
}
