<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StoreAdminResponseContract;

class StoreAdminResponse extends BaseViewResponse implements StoreAdminResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.admins.index');
    }
}
