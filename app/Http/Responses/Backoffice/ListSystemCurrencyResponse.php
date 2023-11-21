<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListSystemCurrencyResponseContract;
use App\Http\Resources\Backoffice\SystemCurrencyResource;

class ListSystemCurrencyResponse extends BaseResponse implements ListSystemCurrencyResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(SystemCurrencyResource::pagination($this->resource), $this->status, $this->headers);
    }
}
