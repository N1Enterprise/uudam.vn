<?php

namespace App\Http\Requests\Frontend;

use App\Contracts\Requests\Frontend\StoreUserSubscribeRequestContract;

class StoreUserSubscribeRequest extends BaseFormRequest implements StoreUserSubscribeRequestContract
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'string', 'max:255']
        ];
    }
}
