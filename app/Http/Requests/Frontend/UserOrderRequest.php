<?php

namespace App\Http\Requests\Frontend;

use App\Contracts\Requests\Frontend\UserOrderRequestContract;
use App\Models\PaymentOption;
use App\Models\ShippingOption;
use Illuminate\Validation\Rule;

class UserOrderRequest extends BaseFormRequest implements UserOrderRequestContract
{
    public function rules(): array
    {
        return [
            'user_note'          => ['nullable', 'string'],
            'shipping_option_id' => ['required', 'integer', Rule::exists(ShippingOption::class, 'id')],
            'payment_option_id'  => ['required', 'integer', Rule::exists(PaymentOption::class, 'id')],
            'redirect_urls'      => ['nullable', 'array'],
        ];
    }
}
