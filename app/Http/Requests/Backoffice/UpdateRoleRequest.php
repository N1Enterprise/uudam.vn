<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UpdateRoleRequestContract;

class UpdateRoleRequest extends BaseFormRequest implements UpdateRoleRequestContract
{
    public function rules(): array
    {
        return [
            'permissions' => ['nullable', 'array'],
        ];
    }
}
