<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Validation\Rule;
use App\Contracts\Requests\Backoffice\StoreMenuGroupRequestContract;
use App\Models\Admin;

class StoreMenuGroupRequest extends BaseFormRequest implements StoreMenuGroupRequestContract
{
    public function rules(): array
    {
        return [

        ];
    }
}
