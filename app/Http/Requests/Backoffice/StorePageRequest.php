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
            'slug' => [Rule::requiredIf(!$this->has_custom_redirect_url), 'string', 'max:255', Rule::unique(Page::class, 'slug')],
            'custom_redirect_url' => [Rule::requiredIf($this->has_custom_redirect_url), 'string', 'url', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'display_type' => ['required', 'integer', Rule::in(PageDisplayTypeEnum::class)],
            'order' => ['nullable', 'integer'],
            'status' => ['required', Rule::in(ActivationStatusEnum::all())],
            'has_contact_form' => ['required', Rule::in(ActivationStatusEnum::all())],
            'description' => ['nullable'],
            'meta_title' => ['nullable', 'max:255'],
            'meta_description' => ['nullable', 'max:255'],
        ];
    }

    public function prepareForValidation()
    {
        $payload = $this->all();
        $hasCustomRedirectUrl = boolean($this->has_custom_redirect_url);

        if ($hasCustomRedirectUrl) {
            $payload['slug'] = '';
        } else {
            $payload['custom_redirect_url'] = '';
        }

        $this->merge(array_merge($payload, [
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'has_contact_form' => boolean($this->has_contact_form) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'description' => $this->description ? json_decode($this->description, true) : null,
            'has_custom_redirect_url' => boolean($this->has_custom_redirect_url)
        ]));
    }
}
