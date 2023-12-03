<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListOrderResponseContract;
use App\Http\Resources\Backoffice\OrderResource;

class ListOrderResponse extends BaseResponse implements ListOrderResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(OrderResource::pagination($this->resource), $this->status, $this->headers);
    }
}
