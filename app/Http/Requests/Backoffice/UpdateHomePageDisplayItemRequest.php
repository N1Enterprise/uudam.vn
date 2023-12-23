<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UpdateHomePageDisplayItemRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Enum\HomePageDisplayType;
use App\Models\Collection;
use App\Models\HomePageDisplayOrder;
use App\Models\Inventory;
use Illuminate\Validation\Rule;

class UpdateHomePageDisplayItemRequest extends BaseFormRequest implements UpdateHomePageDisplayItemRequestContract
{
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'group_id' => ['required', 'integer', Rule::exists(HomePageDisplayOrder::class, 'id')],
            'order' => ['nullable', 'integer'],
            'linked_items' => ['nullable', 'array'],
            'status' => ['required', Rule::in(ActivationStatusEnum::all())],
            'display_on_frontend' => ['required', Rule::in(ActivationStatusEnum::all())],
        ];

        if ($this->type == HomePageDisplayType::PRODUCT) {
            $rules['linked_items.*'] = ['required', 'integer', Rule::exists(Inventory::class, 'id')];
        }

        if ($this->type == HomePageDisplayType::COLLECTION) {
            $rules['linked_items.*'] = ['required', 'integer', Rule::exists(Collection::class, 'id')];
        }

        return $rules;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'linked_items' => empty($this->linked_items) ? [] : array_map('intval', $this->linked_items ?? []),
            'display_on_frontend' => boolean($this->display_on_frontend) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
        ]);
    }
}
