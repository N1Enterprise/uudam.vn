<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdateAdminProfileResponseContract;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Backoffice\AdminResource;

class UpdateAdminProfileResponse extends BaseResponse implements UpdateAdminProfileResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(new AdminResource($this->resource), $this->status, $this->headers);
    }
}
