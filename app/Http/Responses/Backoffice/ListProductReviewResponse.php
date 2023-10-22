<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListProductReviewResponseContract;
use App\Http\Resources\Backoffice\ProductReviewResource;

class ListProductReviewResponse extends BaseResponse implements ListProductReviewResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(ProductReviewResource::pagination($this->resource), $this->status, $this->headers);
    }
}
