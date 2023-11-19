<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListCountryResponseContract;
use App\Http\Resources\Backoffice\CountryResource;

class ListCountryResponse extends BaseResponse implements ListCountryResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(CountryResource::pagination($this->resource), $this->status, $this->headers);
    }
}
