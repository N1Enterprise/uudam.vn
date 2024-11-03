<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StoreUserResponseContract;

class StoreUserResponse extends BaseResponse implements StoreUserResponseContract
{
    public function toResponse($request)
    {
        return route('bo.web.users.index');
    }
}
