<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\DeactivateAdminResponseContract;

class DeactivateAdminResponse extends BaseResponse implements DeactivateAdminResponseContract
{
    public function toResponse($request)
    {
        return $this->redirectBack();
    }
}
