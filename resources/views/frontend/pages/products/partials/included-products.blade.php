@if(count(data_get($inventory, 'includedProducts', [])))
<div class="included-products">
    @foreach (data_get($inventory, 'includedProducts', []) as $product)
    <div class="included-products__item">
        <div class="included-products__item-image" title="{{ $product->description }}">
            <img src="{{ $product->image }}" alt="{{ $product->name }}">
        </div>

        <div class="included-products__item-info">
            <div>
                <h3 class="included-products-info-name" style="margin: 0">{{ $product->name }}</h3>
                <span class="included-products-info-price">{{ format_price($product->sale_price) }}</span>
            </div>
            <div class="included-products__item-sale">
                <div>
                    <div class="product-form__input product-form__quantity">
                        <label class="form__label">Số Lượng</label>
                        <quantity-input class="quantity">
                            <button class="quantity__button no-js-hidden" name="minus" type="button">
                                <span class="visually-hidden">Decrease quantity for {{ $product->name }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" role="presentation" class="icon icon-minus" fill="none" viewBox="0 0 10 2">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M.5 1C.5.7.7.5 1 .5h8a.5.5 0 110 1H1A.5.5 0 01.5 1z" fill="currentColor"></path>
                                </svg>
                            </button>
                            <input class="quantity__input" type="number" name="quantity" min="1" value="1" max="{{ $product->stock_quantity }}">
                            <button class="quantity__button no-js-hidden" name="plus" type="button">
                                <span class="visually-hidden">Increase quantity for {{ $product->name }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" role="presentation" class="icon icon-plus" fill="none" viewBox="0 0 10 10">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M1 4.51a.5.5 0 000 1h3.5l.01 3.5a.5.5 0 001-.01V5.5l3.5-.01a.5.5 0 00-.01-1H5.5L5.49.99a.5.5 0 00-1 .01v3.5l-3.5.01H1z" fill="currentColor"></path>
                                </svg>
                            </button>
                        </quantity-input>
                    </div>
                </div>
                <button type="button" class="included-products-info-order">Mua Kèm</button>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
