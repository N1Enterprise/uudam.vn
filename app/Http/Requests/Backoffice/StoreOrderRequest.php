<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\StoreOrderRequestContract;
use App\Enum\AccessChannelType;
use App\Models\Inventory;
use App\Models\PaymentOption;
use App\Models\ShippingOption;
use App\Models\User;
use App\ValidationRules\PhoneNumberValidate;
use App\Vendors\Localization\District;
use App\Vendors\Localization\Province;
use App\Vendors\Localization\Ward;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends BaseFormRequest implements StoreOrderRequestContract
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', Rule::exists(User::class, 'id')],
            'cart_items' => ['required', 'array'],
            'cart_items.*inventory_id' => ['required', 'int', Rule::exists(Inventory::class, 'id')],
            'cart_items.*quantity' => ['required', 'int', 'gt:0'],
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:15', new PhoneNumberValidate()],
            'company' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:255'],
            'province_code' => ['required', Rule::in(Province::make()->all()->pluck('code'))],
            'district_code' => ['required', Rule::in(District::make()->all()->pluck('code'))],
            'ward_code' => ['required', Rule::in(Ward::make()->all()->pluck('code'))],
            'shipping_option_id' => ['required', Rule::exists(ShippingOption::class, 'id')],
            'payment_option_id' => ['required', Rule::exists(PaymentOption::class, 'id')],
            'order_channel' => ['required', 'array'],
            'order_channel.type' => ['required', Rule::in(AccessChannelType::all())],
            'order_channel.reference_id' => ['nullable', 'string'],
        ];
    }

    public function prepareForValidation()
    {
        $validatedData = $this->all();

        data_set($validatedData, 'order_channel.type', (int) data_get($validatedData, 'order_channel.type'));

        $this->merge($validatedData);
    }
}
