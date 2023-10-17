<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListIncludedProductResponseContract;
use App\Http\Resources\Backoffice\IncludedProductResource;

class ListIncludedProductResponse extends BaseResponse implements ListIncludedProductResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(IncludedProductResource::pagination($this->resource), $this->status, $this->headers);
    }
}
