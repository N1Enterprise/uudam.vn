<?php

namespace App\Http\Responses\Frontend;

use App\Contracts\Responses\Frontend\ListLinkedPostResponseContract;
use App\Http\Resources\Frontend\LinkedPostResource;
use Illuminate\Http\JsonResponse;

class ListLinkedPostResponse extends BaseResponse implements ListLinkedPostResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(LinkedPostResource::pagination($this->resource), $this->status, $this->headers);
    }
}
