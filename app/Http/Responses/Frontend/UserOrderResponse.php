<?php

namespace App\Http\Responses\Frontend;

use App\Contracts\Responses\Frontend\UserOrderResponseContract;
use App\Http\Resources\Frontend\UserOrderResource;
use Illuminate\Http\JsonResponse;

class UserOrderResponse extends BaseResponse implements UserOrderResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(new UserOrderResource($this->resource), $this->status, $this->headers);
    }
}
