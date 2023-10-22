<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdatePageResponseContract;

class UpdatePageResponse extends BaseViewResponse implements UpdatePageResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.pages.index');
    }
}
