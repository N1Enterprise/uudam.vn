<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UpdateShippingProviderRequestContract;
use Illuminate\Validation\Rule;
use App\Enum\ActivationStatusEnum;
use App\Vendors\Localization\Country;
use App\Vendors\Localization\Province;

class UpdateShippingProviderRequest extends BaseFormRequest implements UpdateShippingProviderRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255'],
            'params' => ['nullable', 'array'],
            'status' => ['required', 'integer', Rule::in(ActivationStatusEnum::all())],
            'supported_countries' => ['nullable', 'array'],
            'supported_countries.*' => ['required', Rule::in(Country::make()->all()->pluck('iso2'))],
            'supported_provinces' => ['nullable', 'array'],
            'supported_provinces.*' => ['required', Rule::in(Province::make()->all()->pluck('code'))],
            'logo.file' => ['nullable', 'file', 'image', 'max:5200'],
            'logo.path' => ['nullable', 'string'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'params' => !empty($this->params) ? json_decode($this->params, true) : null,
            'logo' => empty(array_filter($this->logo)) ? null : array_filter($this->logo),
        ]);
    }
}
