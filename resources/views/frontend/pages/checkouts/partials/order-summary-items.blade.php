<div class="order-summary-section order-summary-section-product-list" data-order-summary-section="line-items">
    <table class="product-table">
        <thead>
            <tr>
                <th scope="col">
                    <span class="visually-hidden">Hình ảnh</span>
                </th>
                <th scope="col">
                    <span class="visually-hidden">Mô tả</span>
                </th>
                <th scope="col">
                    <span class="visually-hidden">Số lượng</span>
                </th>
                <th scope="col">
                    <span class="visually-hidden">Giá</span>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cartItems as $cartItem)
            <tr class="product">
                <td class="product-image">
                    <div class="product-thumbnail">
                        <div class="product-thumbnail-wrapper">
                            <img class="product-thumbnail-image" alt="{{ data_get($cartItem, 'inventory.title') }}" src="{{ data_get($cartItem, 'inventory.image') }}">
                        </div>
                        <span class="product-thumbnail-quantity">{{ data_get($cartItem, 'quantity') }}</span>
                    </div>
                </td>
                <td class="product-description">
                    <span class="product-description-name order-summary-emphasis">{{ data_get($cartItem, 'inventory.title') }}</span>
                    @php $attributeValues = data_get($cartItem, 'inventory.attributeValues')->pluck('value', 'attribute_id')->toArray(); @endphp
                    @foreach (data_get($cartItem, 'inventory.attributes', []) as $attribute)
                    <span class="product-description-variant order-summary-small-text">{{ data_get($attribute, 'name') }}: {{ data_get($attributeValues, [data_get($attribute, 'id')]) }} </span>
                    @endforeach
                </td>
                <td class="product-quantity visually-hidden">{{ data_get($cartItem, 'quantity') }}</td>
                <td class="product-price">
                    <span class="order-summary-emphasis">{{ format_price($cartItem->total_price) }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
