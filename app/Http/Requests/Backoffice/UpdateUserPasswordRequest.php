<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UpdateUserPasswordRequestContract;

class UpdateUserPasswordRequest extends BaseFormRequest implements UpdateUserPasswordRequestContract
{
    public function rules(): array
    {
        return [
            'password' => ['nullable', 'string', 'min:6', 'max:255'],
        ];
    }
}
