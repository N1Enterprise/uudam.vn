<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListPageResponseContract;
use App\Http\Resources\Backoffice\PageResource;

class ListPageResponse extends BaseResponse implements ListPageResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(PageResource::pagination($this->resource), $this->status, $this->headers);
    }
}
