<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StoreIncludedProductResponseContract;

class StoreIncludedProductResponse extends BaseViewResponse implements StoreIncludedProductResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.included-products.index');
    }
}
