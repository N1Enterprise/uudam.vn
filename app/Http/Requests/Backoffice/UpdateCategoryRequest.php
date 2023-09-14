<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Validation\Rule;
use App\Contracts\Requests\Backoffice\UpdateCategoryRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Models\Category;

class UpdateCategoryRequest extends BaseFormRequest implements UpdateCategoryRequestContract
{
    public function rules(): array
    {
        $id = $this->id;

        return [
            'name' => ['required', 'max:255', Rule::unique(Category::class, 'name')->ignore($id)],
            'slug' => ['required', 'alpha-dash', 'max:255', Rule::unique(Category::class, 'slug')->ignore($id)],
            'category_group_id' => ['required', 'integer'],
            'description' => ['nullable'],
            'icon_image' => ['nullable', 'file', 'image', 'max:5200'],
            'order' => ['nullable', 'integer', 'gt:0'],
            'status' => ['required', Rule::in(ActivationStatusEnum::all())],
            'featured' => ['required', Rule::in(ActivationStatusEnum::all())],
            'meta_title' => ['nullable', 'max:255'],
            'meta_description' => ['nullable', 'max:255'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'featured' => boolean($this->featured) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
        ]);
    }
}
