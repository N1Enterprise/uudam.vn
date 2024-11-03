<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StoreOrderResponseContract;
use App\Http\Resources\Backoffice\OrderResource;
use Illuminate\Http\JsonResponse;

class StoreOrderResponse extends BaseResponse implements StoreOrderResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(new OrderResource($this->resource), $this->status, $this->headers);
    }
}
