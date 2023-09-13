<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListRoleResponseContract;
use App\Http\Resources\Backoffice\RoleResource;

class ListRoleResponse extends BaseResponse implements ListRoleResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(RoleResource::pagination($this->resource), $this->status, $this->headers);
    }
}
