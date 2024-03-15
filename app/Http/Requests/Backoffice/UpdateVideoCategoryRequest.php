<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UpdateVideoCategoryRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Models\VideoCategory;
use Illuminate\Validation\Rule;

class UpdateVideoCategoryRequest extends BaseFormRequest implements UpdateVideoCategoryRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique(VideoCategory::class, 'slug')->ignore($this->id)],
            'order' => ['nullable', 'integer'],
            'status' => ['required', 'integer'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
        ]);
    }
}
