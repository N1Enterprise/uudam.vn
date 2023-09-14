<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ClearCacheSystemSettingResponseContract;

class ClearCacheSystemSettingResponse extends BaseResponse implements ClearCacheSystemSettingResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(['status' => true], $this->status, $this->headers);
    }
}
