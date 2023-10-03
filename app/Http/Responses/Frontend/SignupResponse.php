<?php

namespace App\Http\Responses\Frontend;

use App\Contracts\Responses\Frontend\SignupResponseContract;
use Illuminate\Http\JsonResponse;

class SignupResponse extends BaseResponse implements SignupResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse($this->resource, $this->status, $this->headers);
    }
}
