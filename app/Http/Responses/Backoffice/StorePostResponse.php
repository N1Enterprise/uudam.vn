<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StorePostResponseContract;

class StorePostResponse extends BaseViewResponse implements StorePostResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.posts.index');
    }
}
