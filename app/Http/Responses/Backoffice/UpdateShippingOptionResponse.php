<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdateShippingOptionResponseContract;

class UpdateShippingOptionResponse extends BaseViewResponse implements UpdateShippingOptionResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.shipping-options.index');
    }
}
