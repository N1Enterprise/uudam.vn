<?php

namespace App\Http\Responses\Frontend;

use App\Contracts\Responses\Frontend\StoreUserProductReviewResponseContract;
use Illuminate\Http\JsonResponse;

class StoreUserProductReviewResponse extends BaseResponse implements StoreUserProductReviewResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(($this->resource), $this->status, $this->headers);
    }
}
