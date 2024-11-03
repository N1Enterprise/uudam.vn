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
            'payment_provider_id' => [Rule::requiredIf(PaymentOptionTypeEnum::isThirdParty($this->type))],
            'online_banking_code' => [Rule::requiredIf(PaymentOptionTypeEnum::isThirdParty($this->type) && $currency->isFiat())],
            'name' => ['required'],
            'min_amount' => ['nullable', 'min:0', 'numeric'],
            'max_amount' => ['nullable', 'gt:min_amount', 'numeric'],
            'status' => ['required'],
            'params' => ['nullable'],
            'display_on_frontend' => ['required', 'boolean'],
            'logo.file' => ['nullable', 'file', 'image', 'max:5200'],
            'logo.path' => ['nullable', 'string'],
            'expanded_content' => ['nullable', 'string'],
            'order' => ['nullable', 'gt:0'],
        ];
        if (empty($this->min_amount)) {
            $rules['max_amount'] = ['nullable', 'numeric'];
        }

        return $rules;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'display_on_frontend' => boolean($this->display_on_frontend),
            'params' => !empty($this->params) ? json_decode($this->params, true) : null,
            'logo' => empty(array_filter($this->logo)) ? null : array_filter($this->logo),
        ]);
    }
}
