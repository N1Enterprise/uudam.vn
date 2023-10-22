<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UploadFileManagerRequestContract;
use Illuminate\Validation\Rule;

class UploadFileManagerRequest extends BaseFormRequest implements UploadFileManagerRequestContract
{
    public function rules(): array
    {
        return [
            'file' => ['required', 'file', 'image', 'max:5200'],
            'disk' => ['required', 'string', 'max:20'],
        ];
    }
}
