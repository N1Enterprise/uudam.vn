<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\UpdateSystemSettingResponseContract;
use App\Http\Resources\Backoffice\SystemSettingResource;

class UpdateSystemSettingResponse extends BaseResponse implements UpdateSystemSettingResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(new SystemSettingResource($this->resource), $this->status, $this->headers);
    }
}
