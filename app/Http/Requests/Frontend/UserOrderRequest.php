<?php

namespace App\Http\Requests\Frontend;

use App\Contracts\Requests\Frontend\UserOrderRequestContract;
use App\Models\PaymentOption;
use App\Models\ShippingRate;
use App\ValidationRules\PhoneNumberValidate;
use App\Vendors\Localization\Country;
use Illuminate\Validation\Rule;

class UserOrderRequest extends BaseFormRequest implements UserOrderRequestContract
{
    public function rules(): array
    {
        return [
            'email' => ['nullable', 'email', 'string:255'],
            'fullname' => ['required', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'country_code' => ['required', 'string', Rule::in(Country::make()->all()->pluck('iso2'))],
            'address_line' => ['required', 'string', 'max:255'],
            'city_name' => ['required', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:255'],
            'user_note' => ['nullable', 'string'],
            'phone' => ['required', 'string', new PhoneNumberValidate],
            'shipping_rate_id' => ['required', 'integer', Rule::exists(ShippingRate::class, 'id')],
            'payment_option_id' => ['required', 'integer', Rule::exists(PaymentOption::class, 'id')],
        ];
    }
}
