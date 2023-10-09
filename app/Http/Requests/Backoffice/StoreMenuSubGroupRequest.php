<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Validation\Rule;
use App\Contracts\Requests\Backoffice\StoreMenuSubGroupRequestContract;

class StoreMenuSubGroupRequest extends BaseFormRequest implements StoreMenuSubGroupRequestContract
{
    public function rules(): array
    {
        return [

        ];
    }
}
