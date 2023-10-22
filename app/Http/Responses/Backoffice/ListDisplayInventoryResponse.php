<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListDisplayInventoryResponseContract;
use App\Http\Resources\Backoffice\DisplayInventoryResource;

class ListDisplayInventoryResponse extends BaseResponse implements ListDisplayInventoryResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(DisplayInventoryResource::pagination($this->resource), $this->status, $this->headers);
    }
}
