<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListCartResponseContract;
use App\Http\Resources\Backoffice\CartResource;

class ListCartResponse extends BaseResponse implements ListCartResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(CartResource::pagination($this->resource), $this->status, $this->headers);
    }
}
