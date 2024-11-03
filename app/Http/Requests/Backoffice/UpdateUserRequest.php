<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Validation\Rule;
use App\Contracts\Requests\Backoffice\UpdateUserRequestContract;
use App\Enum\AccessChannelType;
use App\Models\User;
use App\ValidationRules\PhoneNumberValidate;

class UpdateUserRequest extends BaseFormRequest implements UpdateUserRequestContract
{
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'max:255', Rule::unique(User::class)->ignore($this->route('id'))],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique(User::class)->ignore($this->route('id'))],
            'phone_number' => ['nullable', new PhoneNumberValidate],
            'birthday' => ['nullable', 'date'],
            'access_channel_type' => ['required', Rule::in(AccessChannelType::all())],
            'meta' => ['nullable', 'array'],
            'allow_login' => ['required', 'boolean']
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'allow_login' => boolean($this->allow_login),
        ]);
    }
}
