<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UpdateInventoryRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Enum\InventoryConditionEnum;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\ProductCombo;
use App\Services\InventoryService;
use Illuminate\Validation\Rule;

class UpdateInventoryRequest extends BaseFormRequest implements UpdateInventoryRequestContract
{
    public function rules(): array
    {
        /** @var Inventory */
        $inventory = app(InventoryService::class)->show($this->id);

        $rules = array_merge(
            [
                'title' => ['nullable', 'max:255'],
                'product_id' => ['required', 'integer', Rule::exists(Product::class, 'id')],
                'slug' => ['required', 'max:255', 'alpha-dash', Rule::unique(Inventory::class, 'slug')->ignore($inventory->getKey())],
                'available_from' => ['nullable', 'date'],
                'status' => ['required', Rule::in(ActivationStatusEnum::all())],
                'display_on_frontend' => ['required'],
                'allow_frontend_search' => ['required'],
                'min_order_quantity' => ['required', 'integer', 'gt:0'],
                'condition_note' => ['nullable'],
                'key_features' => ['nullable', 'array'],
                'key_features.*' => ['required', 'array'],
                'key_features.*.title' => ['required', 'string'],
                'meta_title' => ['nullable'],
                'meta_description' => ['nullable'],
                'init_sold_count' => ['nullable'],
                'meta' => ['nullable', 'array'],
                'weight' => ['nullable', 'gt:0'],
                'offer_start' => [
                    Rule::requiredIf(function() {
                        $offerPrices = array_filter(data_get($this->variants, 'offer_price', []));

                        return boolean(count($offerPrices));
                    }),
                    'nullable',
                    'date'
                ],
                'offer_end' => [
                    'nullable',
                    'date',
                    'after:offer_start'
                ],
                'product_combos' => ['nullable', 'array'],
                'product_combos.*.product_combo_id' => ['required', Rule::exists(ProductCombo::class, 'id')],
                'product_combos.*.quantity' => ['required', 'integer'],
            ],
            $this->defineSimpleRules($inventory) ?? []
        );

        return $rules;
    }


    public function prepareForValidation()
    {
        $this->merge([
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'display_on_frontend' => boolean($this->display_on_frontend),
            'allow_frontend_search' => boolean($this->allow_frontend_search),
            'available_from' => $this->available_from ? $this->available_from : now(),
            'min_order_quantity' => $this->min_order_quantity ?? 1,
            'key_features' => collect($this->key_features)->filter(fn($item) => data_get($item, 'title'))->toArray(),
            'meta' => !empty($this->meta) ? json_decode($this->meta, true) : null,
            'product_combos' => collect($this->product_combos ?? [])
                ->filter(function($item) {
                    return data_get($item, 'product_combo_id') && data_get($item, 'quantity') > 0;
                })
                ->map(function($item) {
                    return [
                        'product_combo_id' => (int) data_get($item, 'product_combo_id'),
                        'quantity' => (int) data_get($item, 'quantity')
                    ];
                })
                ->toArray()
        ]);
    }

    protected function defineSimpleRules(Inventory $inventory)
    {
        return [
            'condition' => ['required', 'integer', Rule::in(InventoryConditionEnum::all())],
            // 'sku' => ['required', Rule::unique(Inventory::class, 'sku')->ignore($inventory->getKey())],
            'purchase_price' => ['nullable', 'numeric', 'gt:0'],
            'sale_price' => ['required', 'numeric', 'gt:0'],
            'offer_price' => ['nullable', 'numeric', 'gt:0'],
            'stock_quantity' => ['required', 'integer'],
            'image.file' => ['nullable', 'file', 'image', 'max:5200'],
            'image.path' => ['nullable', 'string'],
            'sale_channels' => ['nullable', 'array'],
            'sale_channels.*' => ['nullable', 'string']
        ];
    }
}
