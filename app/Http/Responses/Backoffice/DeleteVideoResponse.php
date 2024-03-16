<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\DeleteVideoResponseContract;
use Illuminate\Http\JsonResponse;

class DeleteVideoResponse extends BaseResponse implements DeleteVideoResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse($this->resource, $this->status, $this->headers);
    }
}
