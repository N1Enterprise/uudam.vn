<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdateIncludedProductResponseContract;

class UpdateIncludedProductResponse extends BaseViewResponse implements UpdateIncludedProductResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.included-products.index');
    }
}
