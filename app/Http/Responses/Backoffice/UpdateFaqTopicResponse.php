<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdateFaqTopicResponseContract;

class UpdateFaqTopicResponse extends BaseViewResponse implements UpdateFaqTopicResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.faq-topics.index');
    }
}
