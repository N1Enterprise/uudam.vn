<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StoreShippingRateResponseContract;

class StoreShippingRateResponse extends BaseViewResponse implements StoreShippingRateResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.shipping-rates.index');
    }
}
