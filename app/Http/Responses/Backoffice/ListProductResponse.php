<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListProductResponseContract;
use App\Http\Resources\Backoffice\ProductResource;

class ListProductResponse extends BaseResponse implements ListProductResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(ProductResource::pagination($this->resource), $this->status, $this->headers);
    }
}
