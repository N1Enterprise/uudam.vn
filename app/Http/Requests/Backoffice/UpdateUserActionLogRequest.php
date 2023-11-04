<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Validation\Rule;
use App\Contracts\Requests\Backoffice\UpdateUserActionLogRequestContract;
use App\Enum\UserActionEnum;

class UpdateUserActionLogRequest extends BaseFormRequest implements UpdateUserActionLogRequestContract
{
    public function rules(): array
    {
        return [
            'reason' => ['max:150'],
            'type' => [Rule::in(UserActionEnum::type())],
        ];
    }
}
