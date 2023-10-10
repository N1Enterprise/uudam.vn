<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\StoreMenuGroupRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Models\MenuGroup;
use Illuminate\Validation\Rule;

class StoreMenuGroupRequest extends BaseFormRequest implements StoreMenuGroupRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255', Rule::unique(MenuGroup::class, 'name')],
            'redirect_url' => ['required', 'string', 'max:255'],
            'order' => ['nullable', 'integer'],
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
