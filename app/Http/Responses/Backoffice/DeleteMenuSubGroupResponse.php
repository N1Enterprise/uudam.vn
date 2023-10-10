<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\DeleteMenuSubGroupResponseContract;

class DeleteMenuSubGroupResponse extends BaseResponse implements DeleteMenuSubGroupResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse($this->resource, $this->status, $this->headers);
    }
}
