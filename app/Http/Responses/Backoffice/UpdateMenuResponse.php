<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdateMenuResponseContract;

class UpdateMenuResponse extends BaseViewResponse implements UpdateMenuResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.menus.index');
    }
}
