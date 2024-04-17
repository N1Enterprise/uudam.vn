<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\StoreProductReviewRequestContract;
use App\Enum\ProductReviewRatingEnum;
use App\Enum\ProductReviewStatusEnum;
use App\Models\Product;
use Illuminate\Validation\Rule;

class StoreProductReviewRequest extends BaseFormRequest implements StoreProductReviewRequestContract
{
    public function rules(): array
    {
        return [
            'user_name' => ['required', 'string', 'max:255'],
            'user_phone' => ['nullable', 'max:15'],
            'user_email' => ['nullable', 'email', 'string', 'max:255'],
            'rating_type' => ['required', Rule::in(ProductReviewRatingEnum::all())],
            'content' => ['required'],
            'status' => ['required', 'integer', Rule::in(ProductReviewStatusEnum::all())],
            'product_id' => ['required', 'integer', Rule::exists(Product::class, 'id')],
            'is_purchased' => ['required', 'boolean'],
            'images' => ['nullable', 'array'],
            'post_at' => ['required', 'date'],
            'images.*.file' => ['nullable', 'file', 'image', 'max:5200'],
            'images.*.path' => ['nullable', 'string'],
            'images.*.order' => ['nullable', 'string'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status' => ProductReviewStatusEnum::PENDING,
            'is_purchased' => boolean($this->is_purchased),
            'images' => collect(data_get($this, 'image'))
                    ->filter(fn($item) => data_get($item, 'path') || data_get($item, 'file'))
                    ->toArray(),
            'post_at' => $this->post_at ? $this->post_at : now()
        ]);
    }
}
