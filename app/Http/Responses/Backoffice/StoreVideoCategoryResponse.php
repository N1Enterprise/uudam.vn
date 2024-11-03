<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StoreVideoCategoryResponseContract;

class StoreVideoCategoryResponse extends BaseViewResponse implements StoreVideoCategoryResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.video-categories.index');
    }
}
