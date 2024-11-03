<?php

namespace App\Http\Responses\Frontend;

use App\Contracts\Responses\Frontend\ListPostResponseContract;
use App\Http\Resources\Frontend\PostResource;
use Illuminate\Http\JsonResponse;

class ListPostResponse extends BaseResponse implements ListPostResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(PostResource::pagination($this->resource), $this->status, $this->headers);
    }
}
