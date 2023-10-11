<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StorePageResponseContract;

class StorePageResponse extends BaseViewResponse implements StorePageResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.pages.index');
    }
}
