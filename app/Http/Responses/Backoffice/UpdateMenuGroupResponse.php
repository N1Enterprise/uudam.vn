<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdateMenuGroupResponseContract;

class UpdateMenuGroupResponse extends BaseViewResponse implements UpdateMenuGroupResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.menu-groups.index');
    }
}
