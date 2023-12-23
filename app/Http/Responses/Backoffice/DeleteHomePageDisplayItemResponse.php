<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\DeleteHomePageDisplayItemResponseContract;

class DeleteHomePageDisplayItemResponse extends BaseResponse implements DeleteHomePageDisplayItemResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse($this->resource, $this->status, $this->headers);
    }
}
