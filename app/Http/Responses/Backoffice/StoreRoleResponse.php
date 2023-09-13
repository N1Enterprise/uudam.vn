<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StoreRoleResponseContract;

class StoreRoleResponse extends BaseViewResponse implements StoreRoleResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.roles.index');
    }
}
