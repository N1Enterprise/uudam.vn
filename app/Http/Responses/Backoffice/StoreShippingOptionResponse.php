<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StoreShippingOptionResponseContract;

class StoreShippingOptionResponse extends BaseViewResponse implements StoreShippingOptionResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.shipping-options.index');
    }
}
