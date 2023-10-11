<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdateFaqResponseContract;

class UpdateFaqResponse extends BaseViewResponse implements UpdateFaqResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.faqs.index');
    }
}
