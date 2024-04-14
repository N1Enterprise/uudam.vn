<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Validation\Rule;
use App\Contracts\Requests\Backoffice\UpdatePostRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Models\Post;
use App\Models\PostCategory;

class UpdatePostRequest extends BaseFormRequest implements UpdatePostRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'slug' => ['required', 'alpha-dash', 'max:255', Rule::unique(Post::class, 'slug')->ignore($this->id)],
            'code' => ['required', 'max:255', Rule::unique(Post::class, 'code')->ignore($this->id)],
            'image' => ['required', 'array'],
            'image.file' => ['nullable', 'file', 'image', 'max:5200'],
            'image.path' => ['nullable', 'string'],
            'content' => ['nullable'],
            'description' => ['nullable'],
            'post_at' => ['required', 'date'],
            'post_category_id' => ['required', 'integer', Rule::exists(PostCategory::class, 'id')],
            'order' => ['nullable', 'integer', 'gt:0'],
            'status' => ['required', Rule::in(ActivationStatusEnum::all())],
            'meta' => ['nullable', 'array'],
            'meta_title' => ['nullable', 'max:255'],
            'meta_description' => ['nullable'],
            'display_on_frontend' => ['required', Rule::in(ActivationStatusEnum::all())],
            'allow_frontend_search' => ['required', Rule::in(ActivationStatusEnum::all())],
        ];
    }


    public function prepareForValidation()
    {
        $this->merge([
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'display_on_frontend' => boolean($this->display_on_frontend) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'allow_frontend_search' => boolean($this->allow_frontend_search) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'image' => empty(array_filter($this->image)) ? null : array_filter($this->image),
        ]);
    }
}
