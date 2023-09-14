<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\StoreSystemSettingKeyResponseContract;
use App\Http\Resources\Backoffice\SystemSettingResource;

class StoreSystemSettingKeyResponse extends BaseResponse implements StoreSystemSettingKeyResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(new SystemSettingResource($this->resource), $this->status, $this->headers);
    }
}
