<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdateShippingZoneResponseContract;

class UpdateShippingZoneResponse extends BaseViewResponse implements UpdateShippingZoneResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.shipping-zones.index');
    }
}
