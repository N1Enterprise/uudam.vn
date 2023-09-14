<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ImportSystemSettingResponseContract;

class ImportSystemSettingResponse extends BaseResponse implements ImportSystemSettingResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse($this->resource, $this->status, $this->headers);
    }
}
