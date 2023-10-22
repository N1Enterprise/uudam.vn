<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListBannerResponseContract;
use App\Http\Resources\Backoffice\BannerResource;

class ListBannerResponse extends BaseResponse implements ListBannerResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(BannerResource::pagination($this->resource), $this->status, $this->headers);
    }
}
