<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\StoreAttributeValueRequestContract;
use App\Enum\ActivationStatusEnum;
use Illuminate\Validation\Rule;

class StoreAttributeValueRequest extends BaseFormRequest implements StoreAttributeValueRequestContract
{
    public function rules(): array
    {
        return [
            'value' => ['required', 'max:255'],
            'attribute_id' => ['required', 'integer'],
            'order' => ['nullable', 'gt:0'],
            'status' => ['required', Rule::in(ActivationStatusEnum::all())],
        ];
    }


    public function prepareForValidation()
    {
        $this->merge([
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'categories' => array_map('intval', $this->categories ?? []),
        ]);
    }
}
