<?php

namespace App\Http\Requests\Frontend;

use App\Classes\Contracts\UserAuthContract;
use App\Contracts\Requests\Frontend\StoreUserProductReviewRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Enum\ProductReviewRatingEnum;
use App\Enum\ProductReviewStatusEnum;
use App\Models\Product;
use App\ValidationRules\PhoneNumberValidate;
use Illuminate\Validation\Rule;

class StoreUserProductReviewRequest extends BaseFormRequest implements StoreUserProductReviewRequestContract
{
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'integer', Rule::exists(Product::class, 'id')],
            'user_name' => ['required', 'string', 'max:255'],
            'user_phone' => ['required', 'string', 'max:15', new PhoneNumberValidate()],
            'user_email' => ['required', 'email', 'string', 'max:255'],
            'rating_type' => ['required', 'integer', Rule::in(ProductReviewRatingEnum::all())],
            'content' => ['required', 'string', 'max:1500'],
            'is_real_user' => ['required', Rule::in(ActivationStatusEnum::all())],
            'status' => ['required', Rule::in(ActivationStatusEnum::all())],
        ];
    }

    public function prepareForValidation()
    {
        $user = app(UserAuthContract::class)->user();

        $this->merge([
            'is_real_user' => ActivationStatusEnum::ACTIVE,
            'status' => ProductReviewStatusEnum::PENDING,
            'user_name' => $user->name,
            'user_phone' => $user->phone_number,
            'user_email' => $user->email,
        ]);
    }
}
