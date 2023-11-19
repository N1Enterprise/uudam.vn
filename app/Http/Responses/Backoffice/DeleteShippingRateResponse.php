<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\DeleteShippingRateResponseContract;

class DeleteShippingRateResponse extends BaseResponse implements DeleteShippingRateResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse($this->resource, $this->status, $this->headers);
    }
}
