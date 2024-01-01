<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StoreHomePageDisplayItemResponseContract;

class StoreHomePageDisplayItemResponse extends BaseViewResponse implements StoreHomePageDisplayItemResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.home-page-display-items.index');
    }
}
