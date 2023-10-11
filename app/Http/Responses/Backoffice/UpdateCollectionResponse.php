<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdateCollectionResponseContract;

class UpdateCollectionResponse extends BaseViewResponse implements UpdateCollectionResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.collections.index');
    }
}
