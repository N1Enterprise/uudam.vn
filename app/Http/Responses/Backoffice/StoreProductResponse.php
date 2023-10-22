<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StoreProductResponseContract;

class StoreProductResponse extends BaseViewResponse implements StoreProductResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.products.index');
    }
}
