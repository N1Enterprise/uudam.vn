<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\StoreShippingOptionRequestContract;
use Illuminate\Validation\Rule;
use App\Enum\ActivationStatusEnum;
use App\Enum\ShippingOptionTypeEnum;
use App\Models\ShippingProvider;
use App\Vendors\Localization\Country;
use App\Vendors\Localization\Province;

class StoreShippingOptionRequest extends BaseFormRequest implements StoreShippingOptionRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::in(ShippingOptionTypeEnum::all())],
            'params' => ['nullable', 'array'],
            'status' => ['required', 'integer', Rule::in(ActivationStatusEnum::all())],
            'shipping_provider_id' => [Rule::requiredIf(ShippingOptionTypeEnum::isThirdParty($this->type)), 'integer', Rule::exists(ShippingProvider::class, 'id')],
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
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'params' => !empty($this->params) ? json_decode($this->params, true) : null,
            'logo' => empty(array_filter($this->logo)) ? null : array_filter($this->logo),
            'display_on_frontend' => boolean($this->display_on_frontend)
        ]);
    }
}
