<?php

namespace App\Http\Requests\Frontend;

use App\Contracts\Requests\Frontend\UserOauthSigninRequestContract;

class UserOauthSigninRequest extends BaseFormRequest implements UserOauthSigninRequestContract
{
    public function rules(): array
    {
        return [
            'provider' => ['required', 'string'],
            'auth_code' => ['required', 'string'],
        ];
    }
}
