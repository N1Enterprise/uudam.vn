<?php

namespace App\Http\Requests\Frontend;

use App\Contracts\Requests\Frontend\UserOauthSigninRequestContract;
use App\Enum\SystemSettingKeyEnum;
use App\Models\SystemSetting;
use App\Models\User;
use App\ValidationRules\PhoneNumberValidate;
use Illuminate\Validation\Rule;

class UserOauthSigninRequest extends BaseFormRequest implements UserOauthSigninRequestContract
{
    public function rules(): array
    {
        $requiredOauthUserCompleteInformationBeforeSignin = SystemSetting::from(SystemSettingKeyEnum::REQUIRED_OAUTH_USER_COMPLETE_INFORMATION_BEFORE_SIGNIN)->get(null, false);

        $phoneNumber = $this->phone_number;

        return [
            'phone_number' => [Rule::requiredIf($requiredOauthUserCompleteInformationBeforeSignin && $phoneNumber), 'string', 'max:15', Rule::unique(User::class, 'phone_number'), new PhoneNumberValidate()],
            'provider' => ['required', 'string'],
            'auth_code' => ['required', 'string'],
        ];
    }
}
