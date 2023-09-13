<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdateRoleResponseContract;

class UpdateRoleResponse extends BaseViewResponse implements UpdateRoleResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.roles.index');
    }
}
