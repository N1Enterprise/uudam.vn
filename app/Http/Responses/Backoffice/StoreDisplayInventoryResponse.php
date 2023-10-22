<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StoreDisplayInventoryResponseContract;

class StoreDisplayInventoryResponse extends BaseViewResponse implements StoreDisplayInventoryResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.display-inventories.index');
    }
}
