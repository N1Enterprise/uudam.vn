<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListCategoryGroupResponseContract;
use App\Http\Resources\Backoffice\CategoryGroupResource;

class ListCategoryGroupResponse extends BaseResponse implements ListCategoryGroupResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(CategoryGroupResource::pagination($this->resource), $this->status, $this->headers);
    }
}
