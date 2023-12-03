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
            'featured' => ['required', Rule::in(ActivationStatusEnum::all())],
            'meta_title' => ['nullable', 'max:255'],
            'meta_description' => ['nullable', 'max:255'],
            'display_on_frontend' => ['required', 'boolean']
        ];
    }


    public function prepareForValidation()
    {
        $this->merge([
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'featured' => boolean($this->featured) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'display_on_frontend' => boolval($this->display_on_frontend),
            'image' => empty(array_filter($this->image)) ? null : array_filter($this->image),
        ]);
    }
}
