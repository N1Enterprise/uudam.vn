<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdateProductResponseContract;

class UpdateProductResponse extends BaseViewResponse implements UpdateProductResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.products.index');
    }
}
