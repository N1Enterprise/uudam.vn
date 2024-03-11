<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListShippingProviderResponseContract;
use App\Http\Resources\Backoffice\ShippingProviderResource;

class ListShippingProviderResponse extends BaseResponse implements ListShippingProviderResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(ShippingProviderResource::pagination($this->resource), $this->status, $this->headers);
    }
}
