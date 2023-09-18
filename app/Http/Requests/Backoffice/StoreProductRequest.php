<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Validation\Rule;
use App\Contracts\Requests\Backoffice\StoreProductRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Enum\ProductTypeEnum;
use App\Models\Product;

class StoreProductRequest extends BaseFormRequest implements StoreProductRequestContract
{
    public function rules(): array
    {
        dd($this->all());
        return [
            'name' => ['required', 'max:255'],
            'code' => ['required', 'max:255', 'alpha-dash', Rule::unique(Product::class)],
            'slug' => ['required', 'max:255', 'alpha-dash', Rule::unique(Product::class)],
            'type' => ['required', Rule::in(ProductTypeEnum::class)],
            'description' => ['nullable'],
            'status' => ['required', Rule::in(ActivationStatusEnum::all())],
            'branch' => ['nullable', 'max:255'],
            'categories' => ['required', 'array'],
            'categories.*' => ['required', 'integer'],
            'min_amount' => ['required', 'gt:0', 'numeric'],
            'max_amount' => ['nullable', 'gt:min_amount', 'numeric'],
            'type' => ['required', Rule::in(ProductTypeEnum::class)],
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
