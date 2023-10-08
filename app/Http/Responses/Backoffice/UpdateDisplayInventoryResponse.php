<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdateDisplayInventoryResponseContract;

class UpdateDisplayInventoryResponse extends BaseViewResponse implements UpdateDisplayInventoryResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.display-inventories.index');
    }
}
