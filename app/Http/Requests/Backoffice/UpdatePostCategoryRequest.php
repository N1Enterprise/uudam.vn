<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Validation\Rule;
use App\Contracts\Requests\Backoffice\UpdatePostCategoryRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Models\PostCategory;

class UpdatePostCategoryRequest extends BaseFormRequest implements UpdatePostCategoryRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'slug' => ['required', 'alpha-dash', 'max:255', Rule::unique(PostCategory::class, 'slug')->ignore($this->id)],
            'image' => ['required', 'array'],
            'image.file' => ['nullable', 'file', 'image', 'max:5200'],
            'image.path' => ['nullable', 'string'],
            'description' => ['nullable'],
            'order' => ['nullable', 'integer', 'gt:0'],
            'status' => ['required', Rule::in(ActivationStatusEnum::all())],
            'display_on_frontend' => ['required', Rule::in(ActivationStatusEnum::all())],
            'meta_title' => ['nullable', 'max:255'],
            'meta_description' => ['nullable', 'max:255'],
        ];
    }


    public function prepareForValidation()
    {
        $this->merge([
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'display_on_frontend' => boolean($this->display_on_frontend) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'image' => empty(array_filter($this->image)) ? null : array_filter($this->image),
        ]);
    }
}
