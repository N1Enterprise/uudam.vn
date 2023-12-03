<div class="product-combos d-none">
    <label for="confirm-buy-with-combo" class="confirm-buy-with-combo">
        <input data-product-combo-confirm type="checkbox" id="confirm-buy-with-combo" style="margin-bottom: 3px;">
        <span>Mua kèm combo</span>
    </label>

    <div data-product-combo-list class="buy-with-combo d-none" style="margin-top: 10px;">
        @if(count(data_get($inventory, 'productCombos', [])))
            @foreach (data_get($inventory, 'productCombos', []) as $product)
            <div class="product-combos__item">
                <div class="product-combos__item-image" title="{{ $product->description }}">
                    <img src="{{ $product->image }}" alt="{{ $product->name }}">
                </div>

                <div class="product-combos__item-info">
                    <div>
                        <h3 class="product-combos-info-name" style="margin: 0">{{ $product->name }}</h3>
                        <span class="product-combos-info-price">{{ format_price($product->sale_price) }}</span>
                    </div>
                    <div class="product-combos__item-sale">
                        <div class="product-form__input product-form__quantity">
                            <span>{{ data_get($product->pivot, 'quantity') }} {{ $product->unit }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
</div>
