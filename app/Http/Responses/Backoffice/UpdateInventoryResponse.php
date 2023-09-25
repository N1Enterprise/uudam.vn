<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdateInventoryResponseContract;

class UpdateInventoryResponse extends BaseViewResponse implements UpdateInventoryResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.inventories.index');
    }
}
