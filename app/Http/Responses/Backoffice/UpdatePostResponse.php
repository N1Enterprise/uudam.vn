<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdatePostResponseContract;

class UpdatePostResponse extends BaseViewResponse implements UpdatePostResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.posts.index');
    }
}
