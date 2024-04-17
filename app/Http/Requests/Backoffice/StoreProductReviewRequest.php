<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\StoreProductReviewRequestContract;
use App\Enum\ProductReviewRatingEnum;
use App\Enum\ProductReviewStatusEnum;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Validation\Rule;

class StoreProductReviewRequest extends BaseFormRequest implements StoreProductReviewRequestContract
{
    public function rules(): array
    {
        return [
            'user_name' => ['required', 'string', 'max:255'],
            'user_phone' => ['nullable', 'max:15', Rule::unique(ProductReview::class, 'user_phone')],
            'user_email' => ['nullable', 'email', 'string', 'max:255', Rule::unique(ProductReview::class, 'user_email')],
            'rating_type' => ['required', Rule::in(ProductReviewRatingEnum::all())],
            'content' => ['required'],
            'status' => ['required', 'integer', Rule::in(ProductReviewStatusEnum::all())],
            'product_id' => ['required', 'integer', Rule::exists(Product::class, 'id')],
            'is_purchased' => ['required', 'boolean'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status' => ProductReviewStatusEnum::PENDING,
            'is_purchased' => boolean($this->is_purchased)
        ]);
    }
}
