<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Validation\Rule;
use App\Contracts\Requests\Backoffice\UpdateUserRequestContract;
use App\Models\User;
use App\ValidationRules\PhoneNumberValidate;

class UpdateUserRequest extends BaseFormRequest implements UpdateUserRequestContract
{
    public function rules(): array
    {
        return [
            'username'     => ['required', 'string', 'max:255', Rule::unique(User::class)->ignore($this->route('id'))],
            'name'         => ['required', 'string', 'max:255'],
            'email'        => ['required', 'email', Rule::unique(User::class)->ignore($this->route('id'))],
            'phone_number' => [
                'nullable',
                // Rule::unique(User::class, 'phone_number')->ignore($this->route('id')),
                new PhoneNumberValidate
            ],
            'name'         => ['required', 'string', 'max:255'],
            'birthday'     => ['nullable', 'date'],
        ];
    }
}
