<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdateAttributeResponseContract;

class UpdateAttributeResponse extends BaseViewResponse implements UpdateAttributeResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.attributes.index');
    }
}
