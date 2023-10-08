<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\DeleteDisplayInventoryResponseContract;

class DeleteDisplayInventoryResponse extends BaseResponse implements DeleteDisplayInventoryResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse($this->resource, $this->status, $this->headers);
    }
}
