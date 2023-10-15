<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UpdateProductRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Enum\ProductTypeEnum;
use App\Models\Post;
use App\Services\ProductService;
use Illuminate\Validation\Rule;
use App\Models\Product;

class UpdateProductRequest extends BaseFormRequest implements UpdateProductRequestContract
{
    public function rules(): array
    {
        /** @var Product */
        $product = app(ProductService::class)->show($this->id);

        return [
            'name' => ['required', 'max:255'],
            'code' => ['required', 'max:255', 'alpha-dash', Rule::unique(Product::class)->ignore($product->getKey())],
            'slug' => ['required', 'max:255', 'alpha-dash', Rule::unique(Product::class)->ignore($product->getKey())],
            'description' => ['nullable'],
            'status' => ['required', Rule::in(ActivationStatusEnum::all())],
            'branch' => ['nullable', 'max:255'],
            'categories' => ['required', 'array'],
            'categories.*' => ['required', 'integer'],
            'type' => ['required', Rule::in(ProductTypeEnum::all())],
            'primary_image' => ['required', 'array'],
            'primary_image.file' => ['nullable', 'file', 'image', 'max:5200'],
            'primary_image.path' => ['nullable', 'string'],
            'media' => ['nullable', 'array'],
            'media.image' => ['nullable', 'array'],
            'media.image.*.file' => ['nullable', 'file', 'image', 'max:5200'],
            'media.image.*.path' => ['nullable', 'string'],
            'suggested_relationships' => ['nullable', 'array'],
            'suggested_relationships.*.inventories' => ['nullable', 'array'],
            'suggested_relationships.*.inventories.*' => ['required', 'integer', Rule::exists(Inventory::class, 'id')],
            'suggested_relationships.*.posts' => ['nullable', 'array'],
            'suggested_relationships.*.posts.*' => ['required', 'integer', Rule::exists(Post::class, 'id')],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'categories' => array_map('intval', $this->categories ?? []),
            'primary_image' => empty(array_filter($this->primary_image)) ? null : array_filter($this->primary_image),
            'description' => $this->description ? json_decode($this->description, true) : null,
            'media' => array_filter([
                'image' => collect(data_get($this->media, 'image'))
                    ->filter(fn($item) => data_get($item, 'path') || data_get($item, 'file'))
                    ->toArray(),
                'video' => collect(data_get($this->media, 'video'))
                    ->filter(fn($item) => data_get($item, 'path'))
                    ->toArray()
            ]),
            'suggested_relationships' => [
                'inventories' => array_filter(array_map('intval', data_get($this->suggested_relationships, 'inventories', []))),
                'posts' => array_filter(array_map('intval', data_get($this->suggested_relationships, 'posts', []))),
            ],
        ]);
    }
}
