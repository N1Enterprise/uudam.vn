<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StoreMenuGroupResponseContract;

class StoreMenuGroupResponse extends BaseViewResponse implements StoreMenuGroupResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.menu-groups.index');
    }
}
