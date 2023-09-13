<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdateUserResponseContract;

class UpdateUserResponse extends BaseResponse implements UpdateUserResponseContract
{
    public function toResponse($request)
    {
        return redirect()->back();
    }
}
