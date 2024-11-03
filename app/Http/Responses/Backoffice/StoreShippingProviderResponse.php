<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StoreShippingProviderResponseContract;

class StoreShippingProviderResponse extends BaseViewResponse implements StoreShippingProviderResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.shipping-providers.index');
    }
}
