<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdateVideoResponseContract;

class UpdateVideoResponse extends BaseViewResponse implements UpdateVideoResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.videos.index');
    }
}
