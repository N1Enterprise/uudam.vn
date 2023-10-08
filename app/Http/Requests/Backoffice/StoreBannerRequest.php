<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\StoreBannerRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Enum\BannerTypeEnum;
use Illuminate\Validation\Rule;

class StoreBannerRequest extends BaseFormRequest implements StoreBannerRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'cta_label' => ['nullable', 'string', 'max:255'],
            'redirect_url' => ['required', 'string', 'max:255'],
            'order' => ['required', 'integer'],
            'description' => ['nullable'],
            'desktop_image.file' => ['nullable', 'file', 'image', 'max:5200'],
            'desktop_image.path' => ['nullable', 'string'],
            'mobile_image.file' => ['nullable', 'file', 'image', 'max:5200'],
            'mobile_image.path' => ['nullable', 'string'],
            'start_at' => ['required', 'date'],
            'end_at' => ['nullable', 'date', 'after:start_at'],
            'status' => ['required', Rule::in(ActivationStatusEnum::all())],
            'type' => ['required', 'integer', Rule::in(BannerTypeEnum::all())],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'desktop_image' => empty(array_filter($this->desktop_image)) ? null : array_filter($this->desktop_image),
            'mobile_image' => empty(array_filter($this->mobile_image)) ? null : array_filter($this->mobile_image),
            'start_at' => empty($this->start_at) ? now() : $this->start_at,
        ]);
    }
}
