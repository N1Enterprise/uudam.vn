<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdatePaymentOptionResponseContract;

class UpdatePaymentOptionResponse extends BaseViewResponse implements UpdatePaymentOptionResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.payment-options.index');
    }
}
