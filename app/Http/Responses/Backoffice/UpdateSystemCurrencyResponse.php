<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdateSystemCurrencyResponseContract;

class UpdateSystemCurrencyResponse extends BaseViewResponse implements UpdateSystemCurrencyResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.system-currencies.index');
    }
}
