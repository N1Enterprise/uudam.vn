<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListPaymentProviderResponseContract;
use App\Http\Resources\Backoffice\PaymentProviderResource;

class ListPaymentProviderResponse extends BaseResponse implements ListPaymentProviderResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(PaymentProviderResource::pagination($this->resource), $this->status, $this->headers);
    }
}
