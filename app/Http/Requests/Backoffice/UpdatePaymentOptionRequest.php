<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UpdatePaymentOptionRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Enum\PaymentOptionTypeEnum;
use App\Vendors\Localization\SystemCurrency;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdatePaymentOptionRequest extends BaseFormRequest implements UpdatePaymentOptionRequestContract
{
    public function rules(): array
    {
        $validator = Validator::make($this->toArray(), [
            'currency_code' => ['required', Rule::in(SystemCurrency::allConfigurable()->pluck('key'))]
        ]);

        $validator->validate();

        $currency = SystemCurrency::get($this->currency_code);

        $rules = [
            'currency_code' => ['nullable'],
            'type' => [
                'required',
                Rule::in(PaymentOptionTypeEnum::all()),
            ],
            'deposit_bank_id' => [Rule::requiredIf($this->type == PaymentOptionTypeEnum::LOCAL_BANK)],
            'payment_provider_id' => [Rule::requiredIf(PaymentOptionTypeEnum::isThirdParty($this->type))],
            'online_banking_code' => [Rule::requiredIf(PaymentOptionTypeEnum::isThirdParty($this->type) && $currency->isFiat())],
            'name' => ['required'],
            'min_amount' => ['nullable', 'min:0', 'numeric'],
            'max_amount' => ['nullable', 'gt:min_amount', 'numeric'],
            'status' => ['required'],
            'cms_code' => ['nullable', 'alpha_dash', Rule::unique(PaymentOption::class)->ignore($this->route('id'))],
            'cms_params' => ['nullable', 'json'],
            'display_on_frontend' => ['required', 'boolean'],
        ];

        if (empty($this->min_amount)) {
            $rules['max_amount'] = ['nullable', 'numeric'];
        }

        return $rules;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status' => $this->status == 'on' ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
        ]);
    }
}
