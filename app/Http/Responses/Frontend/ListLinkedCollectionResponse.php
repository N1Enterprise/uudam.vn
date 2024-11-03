<?php

namespace App\Http\Responses\Frontend;

use App\Contracts\Responses\Frontend\ListLinkedCollectionResponseContract;
use App\Http\Resources\Frontend\LinkedCollectionResource;
use Illuminate\Http\JsonResponse;

class ListLinkedCollectionResponse extends BaseResponse implements ListLinkedCollectionResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(LinkedCollectionResource::pagination($this->resource), $this->status, $this->headers);
    }
}
