<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\StoreShippingProviderRequestContract;
use Illuminate\Validation\Rule;
use App\Enum\ActivationStatusEnum;

class StoreShippingProviderRequest extends BaseFormRequest implements StoreShippingProviderRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255'],
            'params' => ['nullable', 'array'],
            'status' => ['required', 'integer', Rule::in(ActivationStatusEnum::all())],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'params' => !empty($this->params) ? json_decode($this->params, true) : null,
        ]);
    }
}
