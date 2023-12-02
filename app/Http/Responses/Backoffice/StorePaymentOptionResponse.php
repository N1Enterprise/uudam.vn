<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StorePaymentOptionResponseContract;

class StorePaymentOptionResponse extends BaseViewResponse implements StorePaymentOptionResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.payment-options.index');
    }
}
