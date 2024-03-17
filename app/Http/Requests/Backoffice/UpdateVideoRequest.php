<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UpdateVideoRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Enum\VideoTypeEnum;
use App\Models\VideoCategory;
use Illuminate\Validation\Rule;

class UpdateVideoRequest extends BaseFormRequest implements UpdateVideoRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique(VideoCategory::class, 'slug')->ignore($this->id)],
            'order' => ['nullable', 'integer'],
            'thumbnail.file' => ['nullable', 'file', 'image', 'max:5200'],
            'thumbnail.path' => ['nullable', 'string'],
            'source_url' => ['required', 'string'],
            'type' => ['required', Rule::in(VideoTypeEnum::all())],
            'status' => ['required', 'integer'],
            'description' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'video_category_id' => ['nullable', 'integer', Rule::exists(VideoCategory::class, 'id')],
            'display_on_frontend' => ['required', 'boolean'],
            'meta_title' => ['nullable', 'max:255'],
            'meta_description' => ['nullable', 'max:255'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'thumbnail' => empty(array_filter($this->thumbnail)) ? null : array_filter($this->thumbnail),
            'display_on_frontend' => boolean($this->display_on_frontend),
        ]);
    }
}
