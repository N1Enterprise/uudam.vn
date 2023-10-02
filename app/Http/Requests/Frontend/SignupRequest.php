<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Validation\Rule;
use App\Contracts\Requests\Frontend\SignupRequestContract;

class SignupRequest extends BaseFormRequest implements SignupRequestContract
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'max:255', 'email', Rule::unique('users', 'email')],
            'phone_number' => ['required', 'phone:auto', Rule::unique('users', 'phone_number')],
            'confirm_password' => ['required', 'same:password', 'string', 'min:6'],
        ];
    }
}
