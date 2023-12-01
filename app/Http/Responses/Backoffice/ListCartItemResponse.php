<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListCartItemResponseContract;
use App\Http\Resources\Backoffice\CartItemResource;

class ListCartItemResponse extends BaseResponse implements ListCartItemResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(CartItemResource::pagination($this->resource), $this->status, $this->headers);
    }
}
