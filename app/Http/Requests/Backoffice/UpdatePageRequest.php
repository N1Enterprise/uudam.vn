<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UpdatePageRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Enum\PageDisplayInEnum;
use App\Models\Page;
use Illuminate\Validation\Rule;

class UpdatePageRequest extends BaseFormRequest implements UpdatePageRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique(Page::class, 'slug')->ignore($this->id)],
            'custom_redirect_url' => [Rule::requiredIf($this->has_custom_redirect_url), 'string', 'url', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'order' => ['nullable', 'integer'],
            'status' => ['required', Rule::in(ActivationStatusEnum::all())],
            'content' => ['nullable'],
            'meta_title' => ['nullable', 'max:255'],
            'meta_description' => ['nullable', 'max:255'],
            'display_in' => ['required', 'array'],
            'display_in.*' => ['required', 'string', Rule::in(PageDisplayInEnum::all())],
            'display_on_frontend' => ['required', 'boolean'],
        ];
    }

    public function prepareForValidation()
    {
        $payload = $this->all();

        $this->merge(array_merge($payload, [
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'display_in' => array_filter($this->display_in ?? []),
            'display_on_frontend' => boolean($this->display_on_frontend),
        ]));
    }
}
