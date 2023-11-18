<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StoreShippingZoneResponseContract;

class StoreShippingZoneResponse extends BaseViewResponse implements StoreShippingZoneResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.shipping-zones.index');
    }
}
