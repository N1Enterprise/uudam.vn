<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListMenuSubGroupResponseContract;
use App\Http\Resources\Backoffice\MenuSubGroupResource;

class ListMenuSubGroupResponse extends BaseResponse implements ListMenuSubGroupResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(MenuSubGroupResource::pagination($this->resource), $this->status, $this->headers);
    }
}
