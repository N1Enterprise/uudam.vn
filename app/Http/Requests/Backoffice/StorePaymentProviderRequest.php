<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\StorePaymentProviderRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Enum\PaymentTypeEnum;
use Illuminate\Validation\Rule;

class StorePaymentProviderRequest extends BaseFormRequest implements StorePaymentProviderRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255'],
            'params' => ['nullable'],
            'payment_type' => ['required', 'integer', Rule::in(PaymentTypeEnum::all())],
            'status' => ['required', Rule::in(ActivationStatusEnum::all())],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'params' => !empty($this->params) ? json_decode($this->params) : null,
            'logo' => empty(array_filter($this->logo)) ? null : array_filter($this->logo),
        ]);
    }
}
