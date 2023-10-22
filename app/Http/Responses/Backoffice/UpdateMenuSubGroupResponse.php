<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdateMenuSubGroupResponseContract;

class UpdateMenuSubGroupResponse extends BaseViewResponse implements UpdateMenuSubGroupResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.menu-sub-groups.index');
    }
}
