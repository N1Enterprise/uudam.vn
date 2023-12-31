<?php

namespace App\Http\Requests\Frontend;

use App\Contracts\Requests\Frontend\UserForgotPasswordRequestContract;
use App\Models\User;
use Illuminate\Validation\Rule;

class UserForgotPasswordRequest extends BaseFormRequest implements UserForgotPasswordRequestContract
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'string', 'max:255', Rule::exists(User::class, 'email')],
        ];
    }

    public function messages()
    {
        return [
            'email.max' => 'E-mail không tồn tại.',
            'email.email' => 'E-mail không tồn tại.',
            'email.exists' => 'E-mail không tồn tại.'
        ];
    }
}
