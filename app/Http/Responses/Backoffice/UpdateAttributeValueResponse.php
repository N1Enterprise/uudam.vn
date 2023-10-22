<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdateAttributeValueResponseContract;

class UpdateAttributeValueResponse extends BaseViewResponse implements UpdateAttributeValueResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.attribute-values.index');
    }
}
