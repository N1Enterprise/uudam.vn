<?php

namespace App\Http\Responses\Frontend;

use App\Contracts\Responses\Frontend\UserUpdateCartItemQuantityResponseContract;
use App\Http\Resources\Frontend\CartItemResource;
use Illuminate\Http\JsonResponse;

class UserUpdateCartItemQuantityResponse extends BaseResponse implements UserUpdateCartItemQuantityResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(new CartItemResource($this->resource), $this->status, $this->headers);
    }
}
