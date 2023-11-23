<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListPaymentOptionResponseContract;
use App\Http\Resources\Backoffice\PaymentOptionResource;

class ListPaymentOptionResponse extends BaseResponse implements ListPaymentOptionResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(PaymentOptionResource::pagination($this->resource), $this->status, $this->headers);
    }
}
