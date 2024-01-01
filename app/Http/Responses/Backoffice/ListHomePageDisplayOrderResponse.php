<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListHomePageDisplayOrderResponseContract;
use App\Http\Resources\Backoffice\HomePageDisplayOrderResource;

class ListHomePageDisplayOrderResponse extends BaseResponse implements ListHomePageDisplayOrderResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(HomePageDisplayOrderResource::pagination($this->resource), $this->status, $this->headers);
    }
}
