<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UpdateShippingOptionRequestContract;
use Illuminate\Validation\Rule;
use App\Enum\ActivationStatusEnum;
use App\Enum\ShippingOptionTypeEnum;
use App\Models\ShippingProvider;
use App\Vendors\Localization\Country;
use App\Vendors\Localization\Province;

class UpdateShippingOptionRequest extends BaseFormRequest implements UpdateShippingOptionRequestContract
{
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::in(ShippingOptionTypeEnum::all())],
            'params' => ['nullable', 'array'],
            'status' => ['required', 'integer', Rule::in(ActivationStatusEnum::all())],
            'shipping_provider_id' => ['nullable'],
            'expanded_content' => ['nullable', 'string'],
            'supported_countries' => ['nullable', 'array'],
            'supported_countries.*' => ['required', Rule::in(Country::make()->all()->pluck('iso2'))],
            'supported_provinces' => ['nullable', 'array'],
            'supported_provinces.*' => ['required', Rule::in(Province::make()->all()->pluck('code'))],
            'logo.file' => ['nullable', 'file', 'image', 'max:5200'],
            'logo.path' => ['nullable', 'string'],
            'display_on_frontend' => ['required', 'boolean'],
            'order' => ['nullable', 'integer'],
        ];

        if (ShippingOptionTypeEnum::isThirdParty($this->type)) {
            $rules['shipping_provider_id'] = ['required', Rule::exists(ShippingProvider::class, 'id')];
        }

        return $rules;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'params' => !empty($this->params) ? json_decode($this->params, true) : null,
            'logo' => empty(array_filter($this->logo)) ? null : array_filter($this->logo),
            'display_on_frontend' => boolean($this->display_on_frontend),
            'shipping_provider_id' => ShippingOptionTypeEnum::isThirdParty($this->type) ? $this->shipping_provider_id : null,
        ]);
    }
}
