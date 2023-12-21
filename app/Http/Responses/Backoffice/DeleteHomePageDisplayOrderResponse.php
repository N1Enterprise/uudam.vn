<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\DeleteHomePageDisplayOrderResponseContract;

class DeleteHomePageDisplayOrderResponse extends BaseResponse implements DeleteHomePageDisplayOrderResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse($this->resource, $this->status, $this->headers);
    }
}
