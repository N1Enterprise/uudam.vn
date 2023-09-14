<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\DeleteSystemSettingKeyResponseContract;

class DeleteSystemSettingKeyResponse extends BaseResponse implements DeleteSystemSettingKeyResponseContract
{
    public function toResponse($request)
    {
        return $this->redirect(route('bo.web.system-settings.index', ['tab' => data_get($this->resource, 'tab')]));
    }
}
