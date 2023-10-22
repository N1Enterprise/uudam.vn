<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Validation\Rule;
use App\Contracts\Requests\Backoffice\StoreRoleRequestContract;
use App\Models\Role;

class StoreRoleRequest extends BaseFormRequest implements StoreRoleRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required', Rule::unique(Role::class)],
            'permissions' => ['nullable', 'array'],
        ];
    }
}
