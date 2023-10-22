<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StoreCategoryResponseContract;

class StoreCategoryResponse extends BaseViewResponse implements StoreCategoryResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.categories.index');
    }
}
