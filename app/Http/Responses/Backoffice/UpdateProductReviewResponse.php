<?php

namespace App\Http\Responses\Backoffice;

use App\Contracts\Responses\Backoffice\UpdateProductReviewResponseContract;

class UpdateProductReviewResponse extends BaseViewResponse implements UpdateProductReviewResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('bo.web.product-reviews.index');
    }
}
