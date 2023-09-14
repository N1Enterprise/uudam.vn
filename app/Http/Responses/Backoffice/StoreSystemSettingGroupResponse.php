<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\StoreSystemSettingGroupResponseContract;
use App\Http\Resources\Backoffice\SystemSettingGroupResource;

class StoreSystemSettingGroupResponse extends BaseResponse implements StoreSystemSettingGroupResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(new SystemSettingGroupResource($this->resource), $this->status, $this->headers);
    }
}
