<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UpdateShippingZoneRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Models\Country;
use Illuminate\Validation\Rule;

class UpdateShippingZoneRequest extends BaseFormRequest implements UpdateShippingZoneRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'supported_countries' => ['required', 'array'],
            'supported_countries.*' => ['required', 'string', Rule::in(Country::make()->all()->pluck('iso2'))],
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
