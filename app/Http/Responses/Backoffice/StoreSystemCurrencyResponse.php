<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StoreSystemCurrencyResponseContract;

class StoreSystemCurrencyResponse extends BaseViewResponse implements StoreSystemCurrencyResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.system-currencies.index');
    }
}
