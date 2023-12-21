<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StoreHomePageDisplayOrderResponseContract;

class StoreHomePageDisplayOrderResponse extends BaseViewResponse implements StoreHomePageDisplayOrderResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.home-page-display-orders.index');
    }
}
