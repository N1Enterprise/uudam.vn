<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\StoreCollectionRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Models\Collection;
use App\Models\Inventory;
use Illuminate\Validation\Rule;

class StoreCollectionRequest extends BaseFormRequest implements StoreCollectionRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'slug' => ['required', 'max:255', Rule::unique(Collection::class, 'slug')],
            'primary_image' => ['required', 'array'],
            'primary_image.file' => ['nullable', 'file', 'image', 'max:5200'],
            'primary_image.path' => ['nullable', 'string'],
            'cover_image' => ['required', 'array'],
            'cover_image.file' => ['nullable', 'file', 'image', 'max:5200'],
            'cover_image.path' => ['nullable', 'string'],
            'cta_label' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable'],
            'featured' => ['required', Rule::in(ActivationStatusEnum::all())],
            'status' => ['required', Rule::in(ActivationStatusEnum::all())],
            'display_on_frontend' => ['required', Rule::in(ActivationStatusEnum::all())],
            'inventories' => ['required', 'array'],
            'inventories.*' => ['required', 'integer', Rule::exists(Inventory::class, 'id')],
            'order' => ['nullable', 'integer'],
            'meta_title' => ['nullable', 'max:255'],
            'meta_description' => ['nullable', 'max:255'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'featured' => boolean($this->featured) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'display_on_frontend' => boolean($this->display_on_frontend) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'primary_image' => empty(array_filter($this->primary_image)) ? null : array_filter($this->primary_image),
            'cover_image' => empty(array_filter($this->cover_image)) ? null : array_filter($this->cover_image),
            'inventories' => array_filter($this->inventories ?? []),
        ]);
    }
}
