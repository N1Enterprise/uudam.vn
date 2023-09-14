<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListCategoryResponseContract;
use App\Http\Resources\Backoffice\CategoryResource;

class ListCategoryResponse extends BaseResponse implements ListCategoryResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(CategoryResource::pagination($this->resource), $this->status, $this->headers);
    }
}
