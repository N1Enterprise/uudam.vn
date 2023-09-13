<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\ActiveAdminResponseContract;

class ActiveAdminResponse extends BaseResponse implements ActiveAdminResponseContract
{
    public function toResponse($request)
    {
        return $this->redirectBack();
    }
}
