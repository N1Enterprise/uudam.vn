<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StoreMenuSubGroupResponseContract;

class StoreMenuSubGroupResponse extends BaseViewResponse implements StoreMenuSubGroupResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.menu-sub-groups.index');
    }
}
