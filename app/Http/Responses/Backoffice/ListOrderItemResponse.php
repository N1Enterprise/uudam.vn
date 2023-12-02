<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListOrderItemResponseContract;
use App\Http\Resources\Backoffice\OrderItemResource;

class ListOrderItemResponse extends BaseResponse implements ListOrderItemResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(OrderItemResource::pagination($this->resource), $this->status, $this->headers);
    }
}
