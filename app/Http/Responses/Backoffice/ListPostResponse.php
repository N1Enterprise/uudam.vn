<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListPostResponseContract;
use App\Http\Resources\Backoffice\PostResource;

class ListPostResponse extends BaseResponse implements ListPostResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(PostResource::pagination($this->resource), $this->status, $this->headers);
    }
}
