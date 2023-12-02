<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\StoreSystemCurrencyRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Enum\CurrencyTypeEnum;
use App\Models\SystemCurrency;
use App\Vendors\Localization\Currency;
use Illuminate\Validation\Rule;

class StoreSystemCurrencyRequest extends BaseFormRequest implements StoreSystemCurrencyRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'code' => ['required', Rule::unique(SystemCurrency::class, 'key')],
            'symbol' => ['nullable'],
            'decimals' => ['required', 'numeric', 'min:0', 'max:18'],
            'order' => ['nullable', 'numeric'],
            'type' => ['required', Rule::in(CurrencyTypeEnum::all())],
            'status' => ['required', Rule::in(ActivationStatusEnum::all())],
        ];
    }

    public function prepareForValidation()
    {
        $currency = Currency::make()->find($this->get('currency_id'));

        $this->merge([
            'key' => optional($currency)->code,
            'code' => optional($currency)->code,
            'symbol' => optional($currency)->symbol,
            'type' => optional($currency)->type,
            'decimals' => optional($currency)->decimals,
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
        ]);
    }

    public function messages()
    {
        return [
            'code.unique' => __('The currency has already been taken.')
        ];
    }
}
