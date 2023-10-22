<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StoreAttributeResponseContract;

class StoreAttributeResponse extends BaseViewResponse implements StoreAttributeResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.attributes.index');
    }
}
