<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UpdateHomePageDisplayOrderRequestContract;
use App\Enum\ActivationStatusEnum;
use Illuminate\Validation\Rule;

class UpdateHomePageDisplayOrderRequest extends BaseFormRequest implements UpdateHomePageDisplayOrderRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'order' => ['nullable', 'integer'],
            'status' => ['required', Rule::in(ActivationStatusEnum::all())],
            'display_on_frontend' => ['required', Rule::in(ActivationStatusEnum::all())],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'display_on_frontend' => boolean($this->display_on_frontend) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
        ]);
    }
}
