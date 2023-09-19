<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListInventoryResponseContract;
use App\Http\Resources\Backoffice\InventoryResource;

class ListInventoryResponse extends BaseResponse implements ListInventoryResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(InventoryResource::pagination($this->resource), $this->status, $this->headers);
    }
}
