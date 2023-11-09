<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StoreProductComboResponseContract;

class StoreProductComboResponse extends BaseViewResponse implements StoreProductComboResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.product-combos.index');
    }
}
