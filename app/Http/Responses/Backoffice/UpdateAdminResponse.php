<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdateAdminResponseContract;

class UpdateAdminResponse extends BaseViewResponse implements UpdateAdminResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.admins.index');
    }
}
