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
        return [
            'name' => ['required', 'max:255'],
            'code' => ['required', 'max:255', 'alpha-dash', Rule::unique(Product::class)],
            'slug' => ['required', 'max:255', 'alpha-dash', Rule::unique(Product::class)],
            'description' => ['nullable'],
            'status' => ['required', Rule::in(ActivationStatusEnum::all())],
            'branch' => ['nullable', 'max:255'],
            'categories' => ['required', 'array'],
            'categories.*' => ['required', 'integer'],
            'min_amount' => ['required', 'gt:0', 'numeric'],
            'max_amount' => ['nullable', 'gt:min_amount', 'numeric'],
            'type' => ['required', Rule::in(ProductTypeEnum::all())],
            'primary_image' => ['required', 'array'],
            'primary_image.file' => ['nullable', 'file', 'image', 'max:5200'],
            'primary_image.path' => ['nullable', 'string'],
            'media' => ['nullable', 'array'],
            'media.image' => ['nullable', 'array'],
            'media.image.*.file' => ['nullable', 'file', 'image', 'max:5200'],
            'media.image.*.path' => ['nullable', 'string'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'categories' => array_map('intval', $this->categories ?? []),
            'primary_image' => empty(array_filter($this->primary_image)) ? null : array_filter($this->primary_image),
            'description' => $this->description ? json_decode($this->description, true) : null
        ]);
    }
}
