<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\StoreInventoryRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Enum\InventoryConditionEnum;
use App\Enum\ProductTypeEnum;
use App\Models\Inventory;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Validation\Rule;

class StoreInventoryRequest extends BaseFormRequest implements StoreInventoryRequestContract
{
    public function rules(): array
    {
        /** @var Product */
        $product = app(ProductService::class)->show($this->product_id);

        $rules = array_merge(
            [
                'title' => ['nullable', 'max:255'],
                'product_id' => ['required', 'integer', Rule::exists(Product::class, 'id')],
                'product_slug' => ['required', 'max:255', 'alpha-dash', Rule::unique(Inventory::class, 'slug')],
                'available_from' => ['nullable', 'date'],
                'status' => ['required', Rule::in(ActivationStatusEnum::all())],
                'min_order_quantity' => ['required', 'integer', 'gt:0'],
                'condition_note' => ['nullable'],
                'key_features' => ['nullable', 'array'],
                'key_features.*' => ['required', 'array'],
                'key_features.*.title' => ['required', 'string'],
                'description' => ['nullable'],
                'meta_title' => ['nullable'],
                'meta_description' => ['nullable'],
                'offer_start' => [
                    Rule::requiredIf(function() {
                        $offerPrices = array_filter(data_get($this->variants, 'offer_price', []));

                        return boolean(count($offerPrices));
                    }),
                    'nullable',
                    'date'
                ],
                'offer_end' => [
                    Rule::requiredIf(function() {
                        $offerPrices = array_filter(data_get($this->variants, 'offer_price', []));

                        return boolean(count($offerPrices));
                    }),
                    'nullable',
                    'date',
                    'after:offer_start'
                ],
            ],
            $product->type == ProductTypeEnum::VARIABLE
                ? $this->defineVariantRules() ?? []
                : $this->defineSimpleRules() ?? []
        );

        return $rules;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'description' => $this->description ? json_decode($this->description, true) : null,
            'available_from' => $this->available_from ? $this->available_from : now(),
            'min_order_quantity' => $this->min_order_quantity ?? 1
        ]);
    }

    protected function defineVariantRules()
    {
        return [
            'variants' => ['required', 'array'],
            'variants.attribute' => ['required', 'array'],
            'variants.attribute.*' => ['required', 'array'],
            'variants.image' => ['nullable', 'array'],
            'variants.image.*.path' => ['nullable', 'string'],
            'variants.image.*.file' => ['nullable', 'file', 'image', 'max:5200'],
            'variants.sku' => ['required', 'array'],
            'variants.sku.*' => ['required', 'distinct', Rule::unique(Inventory::class, 'sku')],
            'variants.stock_quantity' => ['required', 'array'],
            'variants.stock_quantity.*' => ['required', 'integer'],
            'variants.purchase_price' => ['nullable', 'array'],
            'variants.purchase_price.*' => ['nullable', 'numeric', 'gt:0'],
            'variants.sale_price' => ['required', 'array'],
            'variants.sale_price.*' => ['required', 'numeric', 'gt:0'],
            'variants.offer_price' => ['nullable', 'array'],
            'variants.offer_price.*' => ['nullable', 'numeric', 'gt:0'],
            'variants.offer_price' => [],
            'variants.condition' => ['required', 'array'],
            'variants.condition.*' => ['required', 'integer', Rule::in(InventoryConditionEnum::all())],
        ];
    }

    protected function defineSimpleRules()
    {
        return [
            'condition' => ['required', 'integer', Rule::in(InventoryConditionEnum::all())],
            'sku' => ['required', 'distinct', Rule::unique(Inventory::class, 'sku')],
            'purchase_price' => ['nullable', 'numeric', 'gt:0'],
            'sale_price' => ['required', 'numeric', 'gt:0'],
            'offer_price' => ['nullable', 'numeric', 'gt:0'],
            'stock_quantity' => ['required', 'integer'],
        ];
    }
}
