<?php

namespace App\Http\Responses\Frontend;

use App\Contracts\Responses\Frontend\ListLinkedBlogResponseContract;
use App\Http\Resources\Frontend\LinkedBlogResource;
use Illuminate\Http\JsonResponse;

class ListLinkedBlogResponse extends BaseResponse implements ListLinkedBlogResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(LinkedBlogResource::pagination($this->resource), $this->status, $this->headers);
    }
}
