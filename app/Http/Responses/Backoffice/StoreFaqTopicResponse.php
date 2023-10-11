<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StoreFaqTopicResponseContract;

class StoreFaqTopicResponse extends BaseViewResponse implements StoreFaqTopicResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.faq-topics.index');
    }
}
