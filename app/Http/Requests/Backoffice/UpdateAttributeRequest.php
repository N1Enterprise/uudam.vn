<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UpdateAttributeRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Enum\ProductAttributeTypeEnum;
use Illuminate\Validation\Rule;

class UpdateAttributeRequest extends BaseFormRequest implements UpdateAttributeRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'attribute_type' => ['required', 'integer', Rule::in(ProductAttributeTypeEnum::all())],
            'order' => ['nullable', 'gt:0'],
            'status' => ['required', Rule::in(ActivationStatusEnum::all())],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['required', 'integer'],
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
