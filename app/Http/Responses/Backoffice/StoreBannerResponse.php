<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StoreBannerResponseContract;

class StoreBannerResponse extends BaseViewResponse implements StoreBannerResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.banners.index');
    }
}
