<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StoreInventoryResponseContract;

class StoreInventoryResponse extends BaseViewResponse implements StoreInventoryResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.inventories.index');
    }
}
