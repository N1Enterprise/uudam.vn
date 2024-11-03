<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdateShippingProviderResponseContract;

class UpdateShippingProviderResponse extends BaseViewResponse implements UpdateShippingProviderResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.shipping-providers.index');
    }
}
