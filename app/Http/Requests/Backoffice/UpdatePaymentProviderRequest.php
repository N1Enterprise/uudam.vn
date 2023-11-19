<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UpdatePaymentProviderRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Enum\PaymentTypeEnum;
use Illuminate\Validation\Rule;

class UpdatePaymentProviderRequest extends BaseFormRequest implements UpdatePaymentProviderRequestContract
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
        ]);
    }
}
