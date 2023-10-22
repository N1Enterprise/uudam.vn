<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UpdateProductReviewRequestContract;
use App\Enum\ProductReviewRatingEnum;
use App\Enum\ProductReviewStatusEnum;
use App\Models\Product;
use App\Models\ProductReview;
use App\Services\ProductReviewService;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class UpdateProductReviewRequest extends BaseFormRequest implements UpdateProductReviewRequestContract
{
    public function rules(): array
    {
        /** @var ProductReview */
        $productReview = app(ProductReviewService::class)->show($this->id);

        $rules = [
            'user_name' => ['required', 'string', 'max:255'],
            'user_phone' => ['nullable', 'max:15', Rule::unique(ProductReview::class, 'user_phone')->ignore($this->id)],
            'user_email' => ['nullable', 'email', 'string', 'max:255', Rule::unique(ProductReview::class, 'user_email')->ignore($this->id)],
            'rating_type' => ['required', 'integer', Rule::in(ProductReviewRatingEnum::all())],
            'content' => ['required'],
            'note' => ['nullable'],
            'status' => ['required', 'integer', Rule::in(ProductReviewStatusEnum::all())],
            'product_id' => ['required', 'integer', Rule::exists(Product::class, 'id')],
        ];

        if ($productReview->is_real_user) {
            $rules = Arr::only($rules, [
                'note',
                'status',
            ]);
        }

        return $rules;
    }
}
