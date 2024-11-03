<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StoreVideoResponseContract;

class StoreVideoResponse extends BaseViewResponse implements StoreVideoResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.videos.index');
    }
}
