<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UpdateShippingZoneRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Models\Country;
use App\Vendors\Localization\District;
use App\Vendors\Localization\Province;
use Illuminate\Validation\Rule;

class UpdateShippingZoneRequest extends BaseFormRequest implements UpdateShippingZoneRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'supported_countries' => ['required', 'array'],
            'supported_countries.*' => ['required', 'string', Rule::in(Country::make()->all()->pluck('iso2'))],
            'supported_provinces' => ['required', 'array'],
            'supported_provinces.*' => ['required', 'string', Rule::in(Province::make()->all()->pluck('code'))],
            'supported_districts' => ['required', 'array'],
            'supported_districts.*' => ['required', 'string', Rule::in(District::make()->all()->pluck('code'))],
            'status' => ['required', Rule::in(ActivationStatusEnum::all())],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
        ]);
    }
}
