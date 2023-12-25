<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Validation\Rule;
use App\Contracts\Requests\Backoffice\StoreMenuSubGroupRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Models\MenuGroup;

class StoreMenuSubGroupRequest extends BaseFormRequest implements StoreMenuSubGroupRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'menu_group_id' => ['required', 'integer', Rule::exists(MenuGroup::class, 'id')],
            'redirect_url' => ['nullable', 'string', 'max:255'],
            'order' => ['nullable', 'integer'],
            'params' => ['nullable'],
            'status' => ['required', Rule::in(ActivationStatusEnum::all())],
            'display_on_frontend' => ['required', Rule::in(ActivationStatusEnum::all())],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'params' => !empty($this->params) ? json_decode($this->params) : null,
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'display_on_frontend' => boolean($this->display_on_frontend) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
        ]);
    }
}
