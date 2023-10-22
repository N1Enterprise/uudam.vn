<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StoreFaqResponseContract;

class StoreFaqResponse extends BaseViewResponse implements StoreFaqResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.faqs.index');
    }
}
