<?php

namespace App\ValidationRules;

use Illuminate\Contracts\Validation\Rule;

class PhoneNumberValidate implements Rule
{
    public function passes($attribute, $value)
    {
        $pattern = '/(84|0[3|5|7|8|9])+([0-9]{8})\b/';

        return preg_match($pattern, $value);
    }

    public function message()
    {
        return __('Phone Number is invalid format.');
    }
}
