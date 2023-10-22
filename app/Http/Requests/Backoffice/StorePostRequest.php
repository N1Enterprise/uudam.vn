<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Validation\Rule;
use App\Contracts\Requests\Backoffice\StorePostRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Models\Post;
use App\Models\PostCategory;

class StorePostRequest extends BaseFormRequest implements StorePostRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'slug' => ['required', 'alpha-dash', 'max:255', Rule::unique(Post::class, 'slug')],
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
        ];
    }


    public function prepareForValidation()
    {
        $this->merge([
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'featured' => boolean($this->featured) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'image' => empty(array_filter($this->image)) ? null : array_filter($this->image),
        ]);
    }
}
