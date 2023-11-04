<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdateUserActionLogResponseContract;

class UpdateUserActionLogResponse extends BaseResponse implements UpdateUserActionLogResponseContract
{
    public function toResponse($request)
    {
        return redirect()->back();
    }
}
