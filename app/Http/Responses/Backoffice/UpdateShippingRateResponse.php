<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdateShippingRateResponseContract;

class UpdateShippingRateResponse extends BaseViewResponse implements UpdateShippingRateResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.shipping-rates.index');
    }
}
