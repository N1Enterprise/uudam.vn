<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListMenuGroupResponseContract;
use App\Http\Resources\Backoffice\MenuGroupResource;

class ListMenuGroupResponse extends BaseResponse implements ListMenuGroupResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(MenuGroupResource::pagination($this->resource), $this->status, $this->headers);
    }
}
