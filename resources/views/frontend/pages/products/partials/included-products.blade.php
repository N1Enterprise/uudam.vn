<div class="included-products">
    @foreach (data_get($inventory, 'includedProducts', []) as $product)
    <div class="included-products__item">
        <div class="included-products__item-image" title="{{ $product->description }}">
            <img src="{{ $product->image }}" alt="{{ $product->name }}" width="40" height="40">
        </div>

        <div class="included-products__item-info">
            <div>
                <h3 class="included-products-info-name" style="margin: 0">{{ $product->name }}</h3>
                <span class="included-products-info-price">{{ format_price($product->sale_price) }}</span>
            </div>
            <div>
                <button type="button" class="included-products-info-order">Mua Kèm</button>
            </div>
        </div>
    </div>
    @endforeach
</div>
