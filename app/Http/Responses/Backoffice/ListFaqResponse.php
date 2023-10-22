<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListFaqResponseContract;
use App\Http\Resources\Backoffice\FaqResource;

class ListFaqResponse extends BaseResponse implements ListFaqResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(FaqResource::pagination($this->resource), $this->status, $this->headers);
    }
}
