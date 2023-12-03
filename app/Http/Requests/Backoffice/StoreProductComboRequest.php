<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\StoreProductComboRequestContract;
use App\Enum\ActivationStatusEnum;
use Illuminate\Validation\Rule;

class StoreProductComboRequest extends BaseFormRequest implements StoreProductComboRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'unit' => ['required', 'string', 'max:255'],
            'image' => ['required', 'array'],
            'image.file' => ['nullable', 'file', 'image', 'max:5200'],
            'image.path' => ['nullable', 'string'],
            'sale_price' => ['required', 'numeric', 'gt:0'],
            'status' => ['required', Rule::in(ActivationStatusEnum::all())],
            'description' => ['nullable'],
            'stock_quantity' => ['required', 'integer'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'image' => empty(array_filter($this->image)) ? null : array_filter($this->image),
        ]);
    }
}
