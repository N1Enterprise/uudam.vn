<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UpdateSystemCurrencyRequestContract;
use App\Enum\ActivationStatusEnum;
use Illuminate\Validation\Rule;

class UpdateSystemCurrencyRequest extends BaseFormRequest implements UpdateSystemCurrencyRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'symbol' => ['nullable'],
            'order' => ['nullable', 'numeric'],
            'status' => ['required', Rule::in(ActivationStatusEnum::all())],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'usable' => boolean($this->usable),
        ]);
    }
}
