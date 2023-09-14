<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Validation\Rule;
use App\Contracts\Requests\Backoffice\UpdateCategoryGroupRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Models\CategoryGroup;

class UpdateCategoryGroupRequest extends BaseFormRequest implements UpdateCategoryGroupRequestContract
{
    public function rules(): array
    {
        $id = $this->id;

        return [
            'name' => ['required', 'max:255', Rule::unique(CategoryGroup::class)->ignore($id)],
            'slug' => ['required', 'alpha-dash', 'max:255', Rule::unique(CategoryGroup::class)->ignore($id)],
            'description' => ['nullable'],
            'icon_image' => ['nullable', 'file', 'image', 'max:5200'],
            'order' => ['nullable', 'integer', 'gt:0'],
            'status' => ['required', Rule::in(ActivationStatusEnum::all())],
            'meta_title' => ['nullable', 'max:255'],
            'meta_description' => ['nullable', 'max:255'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
        ]);
    }
}
