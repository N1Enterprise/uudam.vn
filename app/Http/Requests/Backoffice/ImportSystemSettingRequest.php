<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Validation\Rule;
use App\Contracts\Requests\Backoffice\ImportSystemSettingRequestContract;
use App\Enum\SystemSettingImportOptionEnum;

class ImportSystemSettingRequest extends BaseFormRequest implements ImportSystemSettingRequestContract
{
    public function rules(): array
    {
        return [
            'setting' => ['required', 'json'],
            'option' => ['required', Rule::in(SystemSettingImportOptionEnum::all())],
        ];
    }
}
