<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListFaqTopicResponseContract;
use App\Http\Resources\Backoffice\FaqTopicResource;

class ListFaqTopicResponse extends BaseResponse implements ListFaqTopicResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(FaqTopicResource::pagination($this->resource), $this->status, $this->headers);
    }
}
