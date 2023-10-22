<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\StorePageRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Enum\PageDisplayTypeEnum;
use App\Models\Page;
use Illuminate\Validation\Rule;

class StorePageRequest extends BaseFormRequest implements StorePageRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique(Page::class, 'slug')],
            'title' => ['required', 'string', 'max:255'],
            'display_type' => ['required', 'integer', Rule::in(PageDisplayTypeEnum::all())],
            'order' => ['nullable', 'integer'],
            'status' => ['required', Rule::in(ActivationStatusEnum::all())],
            'content' => ['nullable'],
            'meta_title' => ['nullable', 'max:255'],
            'meta_description' => ['nullable', 'max:255'],
        ];
    }

    public function prepareForValidation()
    {
        $payload = $this->all();

        $this->merge(array_merge($payload, [
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
        ]));
    }
}
