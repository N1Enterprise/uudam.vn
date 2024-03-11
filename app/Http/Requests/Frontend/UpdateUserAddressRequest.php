<?php

namespace App\Http\Requests\Frontend;

use App\Contracts\Requests\Frontend\UpdateUserAddressRequestContract;
use App\ValidationRules\PhoneNumberValidate;
use App\Vendors\Localization\District;
use App\Vendors\Localization\Province;
use App\Vendors\Localization\Ward;
use Illuminate\Validation\Rule;

class UpdateUserAddressRequest extends BaseFormRequest implements UpdateUserAddressRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'string', 'max:255'],  
            'phone' => ['required', 'string', 'max:15', new PhoneNumberValidate()],
            'province_code' => ['required', Rule::in(Province::make()->all()->pluck('code'))],
            'district_code' => ['required', Rule::in(District::make()->all()->pluck('code'))],
            'ward_code' => ['required', Rule::in(Ward::make()->all()->pluck('code'))],
            'address_line' => ['required', 'string'],
            'is_default' => ['required', 'boolean'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'is_default' => boolean($this->is_default),
        ]);
    }
}
