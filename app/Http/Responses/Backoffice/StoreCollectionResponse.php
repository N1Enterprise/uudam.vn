<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StoreCollectionResponseContract;

class StoreCollectionResponse extends BaseViewResponse implements StoreCollectionResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.collections.index');
    }
}
