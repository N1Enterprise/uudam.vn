<?php

namespace App\Http\Responses\Frontend;

use App\Contracts\Responses\Frontend\ListLinkedBannerResponseContract;
use App\Http\Resources\Frontend\LinkedBannerResource;
use Illuminate\Http\JsonResponse;

class ListLinkedBannerResponse extends BaseResponse implements ListLinkedBannerResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(LinkedBannerResource::pagination($this->resource), $this->status, $this->headers);
    }
}
