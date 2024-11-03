<?php

namespace App\Http\Responses\Frontend;

use App\Contracts\Responses\Frontend\StoreUserAddressResponseContract;
use App\Http\Resources\Frontend\UserAddressResource;
use Illuminate\Http\JsonResponse;

class StoreUserAddressResponse extends BaseResponse implements StoreUserAddressResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(new UserAddressResource($this->resource), $this->status, $this->headers);
    }
}
