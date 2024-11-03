<?php

namespace App\Http\Requests\Backoffice;

use App\Classes\AdminAuth;
use Illuminate\Validation\Rule;
use App\Contracts\Requests\Backoffice\StorePostRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Product;
use Illuminate\Support\Arr;

class StorePostRequest extends BaseFormRequest implements StorePostRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'slug' => ['required', 'alpha-dash', 'max:255', Rule::unique(Post::class, 'slug')],
            'code' => ['required', 'max:255', Rule::unique(Post::class, 'code')],
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
            'author' => ['required', 'string', 'max:255'],
            'linked_products' => ['nullable', 'array'],
            'linked_products.*' => ['required', Rule::exists(Product::class, 'id')],
        ];
    }


    public function prepareForValidation()
    {
        $admin = AdminAuth::user();

        $this->merge([
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'display_on_frontend' => boolean($this->display_on_frontend) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'allow_frontend_search' => boolean($this->allow_frontend_search) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'image' => empty(array_filter($this->image)) ? null : array_filter($this->image),
            'author' => !empty($this->author) ? $this->author : $admin->name,
            'linked_products' => array_map('intval', Arr::wrap($this->linked_products))
        ]);
    }
}
