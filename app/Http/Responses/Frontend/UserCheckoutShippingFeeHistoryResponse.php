<?php

namespace App\Http\Responses\Frontend;

use App\Contracts\Responses\Frontend\UserCheckoutShippingFeeHistoryResponseContract;
use App\Http\Resources\Frontend\UserCheckoutShippingFeeHistoryResource;
use Illuminate\Http\JsonResponse;

class UserCheckoutShippingFeeHistoryResponse extends BaseResponse implements UserCheckoutShippingFeeHistoryResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(new UserCheckoutShippingFeeHistoryResource($this->resource), $this->status, $this->headers);
    }
}
