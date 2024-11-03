<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdateHomePageDisplayItemResponseContract;

class UpdateHomePageDisplayItemResponse extends BaseViewResponse implements UpdateHomePageDisplayItemResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.home-page-display-items.index');
    }
}
