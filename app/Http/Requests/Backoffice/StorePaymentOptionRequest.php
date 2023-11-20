<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\StorePaymentOptionRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Enum\PaymentOptionTypeEnum;
use App\Enum\PaymentTypeEnum;
use App\Services\PaymentProviderService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StorePaymentOptionRequest extends BaseFormRequest implements StorePaymentOptionRequestContract
{
    public function rules(): array
    {
        $isVoucher = false;

        if (PaymentOptionTypeEnum::isThirdParty($this->type) && $this->payment_provider_id) {
            $paymentProvider = app(PaymentProviderService::class)->show($this->payment_provider_id);
        }

        $validator = Validator::make($this->toArray(), [
            'currency_code' => ['required', Rule::in(SystemCurrency::allConfigurable()->pluck('key'))]
        ]);

        $validator->validate();

        $currency = SystemCurrency::get($this->currency_code);

        $blockchainNetworkAvailable = $currency->getAvailableBlockchainNetworks()->pluck('network_code');

        $rules = [
            'currency_code' => ['nullable'],
            'type' => [
                'required',
                Rule::in(PaymentOptionType::all()),
            ],
            'deposit_bank_id' => [Rule::requiredIf($this->type == PaymentOptionType::LOCAL_BANK)],
            'payment_provider_id' => [Rule::requiredIf(PaymentOptionType::isThirdParty($this->type))],
            'online_banking_code' => [Rule::requiredIf(PaymentOptionType::isThirdParty($this->type) && ! $isVoucher && $currency->isFiat())],
            'name' => ['required'],
            'min_amount' => ['nullable', 'min:0', 'numeric'],
            'max_amount' => ['nullable', 'gt:min_amount', 'numeric'],
            'status' => ['required'],
            'cms_code' => ['nullable', 'alpha-dash', Rule::unique(PaymentOption::class)],
            'cms_params' => ['nullable', 'json'],
            'display_on_frontend' => ['required', 'boolean'],
            'blockchain_networks' => ['array', Rule::requiredIf($currency->isCrypto())],
            'blockchain_networks.*' => [Rule::in($blockchainNetworkAvailable)],
            'payment_option_allowed_countries' => ['present', 'array'],
            'payment_option_allowed_countries.*' => ['nullable', Rule::in(Country::make()->all()->pluck('iso2'))],
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
            'params' => !empty($this->params) ? json_decode($this->params) : null,
        ]);
    }
}
