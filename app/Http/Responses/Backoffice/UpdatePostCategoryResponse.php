<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdatePostCategoryResponseContract;

class UpdatePostCategoryResponse extends BaseViewResponse implements UpdatePostCategoryResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.post-categories.index');
    }
}
