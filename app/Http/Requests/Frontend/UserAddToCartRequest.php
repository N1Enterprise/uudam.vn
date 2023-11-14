<?php

namespace App\Http\Requests\Frontend;

use App\Contracts\Requests\Frontend\UserAddToCartRequestContract;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Validation\Rule;

class UserAddToCartRequest extends BaseFormRequest implements UserAddToCartRequestContract
{
    public function rules(): array
    {
        return [
            'has_combo' => ['required', 'integer'],
            'inventory_id' => ['required', 'integer', Rule::exists(Inventory::class, 'id')],
            'product_id' => ['required', 'integer', Rule::exists(Product::class, 'id')],
            'quantity' => ['required', 'integer', 'gt:0']
        ];
    }
}
