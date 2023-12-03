<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListCarrierResponseContract;
use App\Http\Resources\Backoffice\CarrierResource;

class ListCarrierResponse extends BaseResponse implements ListCarrierResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(CarrierResource::pagination($this->resource), $this->status, $this->headers);
    }
}
