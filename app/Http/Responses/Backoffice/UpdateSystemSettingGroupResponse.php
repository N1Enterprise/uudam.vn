<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdateSystemSettingGroupResponseContract;
use App\Http\Resources\Backoffice\SystemSettingGroupResource;
use App\Http\Responses\Backoffice\BaseResponse;
use Illuminate\Http\JsonResponse;

class UpdateSystemSettingGroupResponse extends BaseResponse implements UpdateSystemSettingGroupResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(new SystemSettingGroupResource($this->resource), $this->status, $this->headers);
    }
}
