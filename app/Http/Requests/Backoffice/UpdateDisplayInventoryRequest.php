<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UpdateDisplayInventoryRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Enum\DisplayInventoryTypeEnum;
use App\Models\Inventory;
use Illuminate\Validation\Rule;

class UpdateDisplayInventoryRequest extends BaseFormRequest implements UpdateDisplayInventoryRequestContract
{
    public function rules(): array
    {
        return [
            'inventory_id' => ['required', 'integer', Rule::exists(Inventory::class, 'id')],
            'type' => ['required', 'integer', Rule::in(DisplayInventoryTypeEnum::all())],
            'order' => ['nullable', 'integer'],
            'redirect_url' => ['nullable', 'url'],
            'status' => ['required', Rule::in(ActivationStatusEnum::all())],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
        ]);
    }
}
