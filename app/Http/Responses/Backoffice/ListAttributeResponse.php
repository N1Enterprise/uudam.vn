<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListAttributeResponseContract;
use App\Http\Resources\Backoffice\AttributeResource;

class ListAttributeResponse extends BaseResponse implements ListAttributeResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(AttributeResource::pagination($this->resource), $this->status, $this->headers);
    }
}
