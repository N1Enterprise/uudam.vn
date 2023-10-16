<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\StoreProductReviewResponseContract;

class StoreProductReviewResponse extends BaseViewResponse implements StoreProductReviewResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.product-reviews.index');
    }
}
