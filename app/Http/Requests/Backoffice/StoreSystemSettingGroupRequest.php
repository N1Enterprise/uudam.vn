<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Validation\Rule;
use App\Contracts\Requests\Backoffice\StoreSystemSettingGroupRequestContract;
use App\Models\SystemSettingGroup;

class StoreSystemSettingGroupRequest extends BaseFormRequest implements StoreSystemSettingGroupRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['regex:/^(?=.*[a-zA-Z]).+$/', 'alpha-dash', Rule::unique(SystemSettingGroup::class)],
            'order' => ['nullable', 'integer']
        ];
    }
}
