<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\DeleteVideoCategoryResponseContract;
use Illuminate\Http\JsonResponse;

class DeleteVideoCategoryResponse extends BaseResponse implements DeleteVideoCategoryResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse($this->resource, $this->status, $this->headers);
    }
}
