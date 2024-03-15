<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\StoreVideoCategoryRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Models\VideoCategory;
use Illuminate\Validation\Rule;

class StoreVideoCategoryRequest extends BaseFormRequest implements StoreVideoCategoryRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique(VideoCategory::class, 'slug')],
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
