<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdateCarrierResponseContract;

class UpdateCarrierResponse extends BaseViewResponse implements UpdateCarrierResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.carriers.index');
    }
}
