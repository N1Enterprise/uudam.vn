<?php

namespace App\Http\Responses\Frontend;

use App\Contracts\Responses\Frontend\ListLinkedInventoryResponseContract;
use App\Http\Resources\Frontend\LinkedInventoryResource;
use Illuminate\Http\JsonResponse;

class ListLinkedInventoryResponse extends BaseResponse implements ListLinkedInventoryResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(LinkedInventoryResource::pagination($this->resource), $this->status, $this->headers);
    }
}
