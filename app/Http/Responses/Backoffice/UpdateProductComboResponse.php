<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdateProductComboResponseContract;

class UpdateProductComboResponse extends BaseViewResponse implements UpdateProductComboResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.product-combos.index');
    }
}
