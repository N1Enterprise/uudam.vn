<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\DeleteSystemSettingGroupResponseContract;

class DeleteSystemSettingGroupResponse extends BaseResponse implements DeleteSystemSettingGroupResponseContract
{
    public function toResponse($request)
    {
        return $this->redirect(route('bo.web.system-settings.index'));
    }
}
