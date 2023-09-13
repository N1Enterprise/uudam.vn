<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListUserResponseContract;
use App\Http\Resources\Backoffice\UserResource;

class ListUserResponse extends BaseResponse implements ListUserResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(UserResource::pagination($this->resource), $this->status, $this->headers);
    }
}
