<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\DeleteVideoCategoryResponseContract;

class DeleteVideoCategoryResponse extends BaseViewResponse implements DeleteVideoCategoryResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.video-categories.index');
    }
}
