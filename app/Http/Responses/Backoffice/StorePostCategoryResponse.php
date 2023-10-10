<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StorePostCategoryResponseContract;

class StorePostCategoryResponse extends BaseViewResponse implements StorePostCategoryResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.post-categories.index');
    }
}
