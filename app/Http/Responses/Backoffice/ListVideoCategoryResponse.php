<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListVideoCategoryResponseContract;
use App\Http\Resources\Backoffice\VideoCategoryResource;

class ListVideoCategoryResponse extends BaseResponse implements ListVideoCategoryResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(VideoCategoryResource::pagination($this->resource), $this->status, $this->headers);
    }
}
