<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdateCategoryGroupResponseContract;

class UpdateCategoryGroupResponse extends BaseViewResponse implements UpdateCategoryGroupResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.category-groups.index');
    }
}
