<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UpdateMenuSubGroupRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Models\MenuGroup;
use Illuminate\Validation\Rule;

class UpdateMenuSubGroupRequest extends BaseFormRequest implements UpdateMenuSubGroupRequestContract
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
