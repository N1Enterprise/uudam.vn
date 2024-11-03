<?php

namespace App\Http\Responses\Frontend;

use App\Contracts\Responses\Frontend\ShowUserAddressResponseContract;
use App\Http\Resources\Frontend\UserAddressResource;
use Illuminate\Http\JsonResponse;

class ShowUserAddressResponse extends BaseResponse implements ShowUserAddressResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(new UserAddressResource($this->resource), $this->status, $this->headers);
    }
}
