<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListAttributeValueResponseContract;
use App\Http\Resources\Backoffice\AttributeValueResource;

class ListAttributeValueResponse extends BaseResponse implements ListAttributeValueResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(AttributeValueResource::pagination($this->resource), $this->status, $this->headers);
    }
}
