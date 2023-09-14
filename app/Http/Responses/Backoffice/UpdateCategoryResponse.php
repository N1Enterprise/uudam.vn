<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdateCategoryResponseContract;

class UpdateCategoryResponse extends BaseViewResponse implements UpdateCategoryResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.categories.index');
    }
}
