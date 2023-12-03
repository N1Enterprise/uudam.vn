<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StorePaymentProviderResponseContract;

class StorePaymentProviderResponse extends BaseViewResponse implements StorePaymentProviderResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.payment-providers.index');
    }
}
