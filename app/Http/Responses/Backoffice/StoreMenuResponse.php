<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StoreMenuResponseContract;

class StoreMenuResponse extends BaseViewResponse implements StoreMenuResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.menus.index');
    }
}
