<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListCurrencyResponseContract;
use App\Http\Resources\Backoffice\CurrencyResource;

class ListCurrencyResponse extends BaseResponse implements ListCurrencyResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(CurrencyResource::pagination($this->resource), $this->status, $this->headers);
    }
}
