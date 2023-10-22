<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StoreAttributeValueResponseContract;

class StoreAttributeValueResponse extends BaseViewResponse implements StoreAttributeValueResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.attribute-values.index');
    }
}
