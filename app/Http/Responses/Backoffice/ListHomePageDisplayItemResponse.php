<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListHomePageDisplayItemResponseContract;
use App\Http\Resources\Backoffice\HomePageDisplayItemResource;

class ListHomePageDisplayItemResponse extends BaseResponse implements ListHomePageDisplayItemResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(HomePageDisplayItemResource::pagination($this->resource), $this->status, $this->headers);
    }
}
