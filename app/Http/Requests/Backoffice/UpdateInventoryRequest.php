<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UpdateInventoryRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Enum\InventoryConditionEnum;
use App\Enum\ProductTypeEnum;
use App\Models\Inventory;
use App\Models\Product;
use App\Services\InventoryService;
use App\Services\ProductService;
use Illuminate\Validation\Rule;

class UpdateInventoryRequest extends BaseFormRequest implements UpdateInventoryRequestContract
{
    public function rules(): array
    {
        /** @var Product */
        $product = app(ProductService::class)->show($this->product_id);

        /** @var Inventory */
        $inventory = app(InventoryService::class)->show($this->id);

        $rules = array_merge(
            [
                'title' => ['nullable', 'max:255'],
                'product_id' => ['required', 'integer', Rule::exists(Product::class, 'id')],
                'slug' => ['required', 'max:255', 'alpha-dash', Rule::unique(Inventory::class, 'slug')->ignore($inventory->getKey())],
                'available_from' => ['nullable', 'date'],
                'status' => ['required', Rule::in(ActivationStatusEnum::all())],
                'min_order_quantity' => ['required', 'integer', 'gt:0'],
                'condition_note' => ['nullable'],
                'variants' => [
                    $product->type == ProductTypeEnum::VARIABLE ? 'required' : 'nullable',
                    'array'
                ],
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
            $this->defineSimpleRules($inventory) ?? []
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

    protected function defineSimpleRules(Inventory $inventory)
    {
        return [
            'condition' => ['required', 'integer', Rule::in(InventoryConditionEnum::all())],
            'sku' => ['required', 'distinct', Rule::unique(Inventory::class, 'sku')->ignore($inventory->getKey())],
            'purchase_price' => ['nullable', 'numeric', 'gt:0'],
            'sale_price' => ['required', 'numeric', 'gt:0'],
            'offer_price' => ['nullable', 'numeric', 'gt:0'],
            'stock_quantity' => ['required', 'integer'],
            'image.file' => ['nullable', 'file', 'image', 'max:5200'],
            'image.path' => ['nullable', 'string'],
        ];
    }
}
