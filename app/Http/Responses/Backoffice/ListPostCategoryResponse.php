<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListPostCategoryResponseContract;
use App\Http\Resources\Backoffice\PostCategoryResource;

class ListPostCategoryResponse extends BaseResponse implements ListPostCategoryResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(PostCategoryResource::pagination($this->resource), $this->status, $this->headers);
    }
}
