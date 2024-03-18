<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdateVideoCategoryResponseContract;

class UpdateVideoCategoryResponse extends BaseViewResponse implements UpdateVideoCategoryResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.video-categories.index');
    }
}
