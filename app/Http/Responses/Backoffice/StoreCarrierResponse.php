<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StoreCarrierResponseContract;

class StoreCarrierResponse extends BaseViewResponse implements StoreCarrierResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.carriers.index');
    }
}
