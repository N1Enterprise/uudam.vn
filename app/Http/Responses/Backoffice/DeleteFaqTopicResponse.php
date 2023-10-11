<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\DeleteFaqTopicResponseContract;

class DeleteFaqTopicResponse extends BaseResponse implements DeleteFaqTopicResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse($this->resource, $this->status, $this->headers);
    }
}
