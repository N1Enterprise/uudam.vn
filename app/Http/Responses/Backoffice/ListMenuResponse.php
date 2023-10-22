<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListMenuResponseContract;
use App\Http\Resources\Backoffice\MenuResource;

class ListMenuResponse extends BaseResponse implements ListMenuResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(MenuResource::pagination($this->resource), $this->status, $this->headers);
    }
}
