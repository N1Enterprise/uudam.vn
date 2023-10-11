<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UpdateFaqTopicRequestContract;
use App\Enum\ActivationStatusEnum;
use Illuminate\Validation\Rule;

class UpdateFaqTopicRequest extends BaseFormRequest implements UpdateFaqTopicRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'order' => ['nullable', 'integer'],
            'status' => ['required', Rule::in(ActivationStatusEnum::all())],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
        ]);
    }
}
