<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListProductComboResponseContract;
use App\Http\Resources\Backoffice\ProductComboResource;

class ListProductComboResponse extends BaseResponse implements ListProductComboResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(ProductComboResource::pagination($this->resource), $this->status, $this->headers);
    }
}
