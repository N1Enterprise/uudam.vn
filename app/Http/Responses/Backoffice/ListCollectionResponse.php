<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListCollectionResponseContract;
use App\Http\Resources\Backoffice\CollectionResource;

class ListCollectionResponse extends BaseResponse implements ListCollectionResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(CollectionResource::pagination($this->resource), $this->status, $this->headers);
    }
}
