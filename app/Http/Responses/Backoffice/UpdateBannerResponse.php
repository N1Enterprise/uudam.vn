<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdateBannerResponseContract;

class UpdateBannerResponse extends BaseViewResponse implements UpdateBannerResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.banners.index');
    }
}
