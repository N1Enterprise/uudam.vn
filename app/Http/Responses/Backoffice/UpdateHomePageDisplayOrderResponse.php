<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdateHomePageDisplayOrderResponseContract;

class UpdateHomePageDisplayOrderResponse extends BaseViewResponse implements UpdateHomePageDisplayOrderResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.home-page-display-orders.index');
    }
}
