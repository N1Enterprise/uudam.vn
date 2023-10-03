<?php

namespace App\Http\Responses\Frontend;

use App\Contracts\Responses\Frontend\SigninResponseContract;
use Illuminate\Http\JsonResponse;

class SigninResponse extends BaseResponse implements SigninResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse($this->resource, $this->status, $this->headers);
    }
}
