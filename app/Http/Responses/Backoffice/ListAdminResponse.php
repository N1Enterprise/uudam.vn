<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListAdminResponseContract;
use App\Http\Resources\Backoffice\AdminResource;

class ListAdminResponse extends BaseResponse implements ListAdminResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(AdminResource::pagination($this->resource), $this->status, $this->headers);
    }
}
