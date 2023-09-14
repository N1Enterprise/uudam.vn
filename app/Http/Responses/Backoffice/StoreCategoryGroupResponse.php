<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StoreCategoryGroupResponseContract;

class StoreCategoryGroupResponse extends BaseViewResponse implements StoreCategoryGroupResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.category-groups.index');
    }
}
