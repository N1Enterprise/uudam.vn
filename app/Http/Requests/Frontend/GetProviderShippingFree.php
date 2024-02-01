<?php

namespace App\Http\Requests\Frontend;

use App\Contracts\Requests\Frontend\GetProviderShippingFreeContract;
use App\Models\Address;
use App\Models\ShippingOption;
use Illuminate\Validation\Rule;

class GetProviderShippingFree extends BaseFormRequest implements GetProviderShippingFreeContract
{
    public function rules(): array
    {
        return [
            'shipping_option_id' => ['required', Rule::exists(ShippingOption::class, 'id')],
            'address_id' => ['required', Rule::exists(Address::class, 'id')],
        ];
    }
}
