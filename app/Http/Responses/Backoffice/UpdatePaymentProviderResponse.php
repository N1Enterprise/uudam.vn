<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdatePaymentProviderResponseContract;

class UpdatePaymentProviderResponse extends BaseViewResponse implements UpdatePaymentProviderResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.payment-providers.index');
    }
}
