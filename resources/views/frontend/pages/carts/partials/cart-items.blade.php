<div class="page-width section-template__cart-items-padding">
    <div class="title-wrapper-with-link">
        <h1 class="title title--primary">Giỏ hàng</h1>
        <a href="{{ route('fe.web.home') }}" class="underlined-link">Tiếp tục mua hàng</a>
    </div>
    <div class="cart__warnings">
        <h1 class="cart__empty-text">Giỏ hàng is empty</h1>
        <a href="{{ route('fe.web.home') }}" class="button"> Tiếp tục mua hàng </a>
    </div>
    <div class="cart__items" id="main-cart-items" data-id="template--16599720296698__cart-items">
        <div class="js-contents">
            <table class="cart-items">
                <caption class="visually-hidden">Giỏ hàng</caption>
                <thead>
                    <tr>
                        <th class="caption-with-letter-spacing" colspan="2" scope="col">Sản phẩm</th>
                        <th class="medium-hide large-up-hide right caption-with-letter-spacing" colspan="1" scope="col">Total</th>
                        <th class="cart-items__heading--wide small-hide caption-with-letter-spacing" colspan="1" scope="col">Số lượng</th>
                        <th class="small-hide right caption-with-letter-spacing" colspan="1" scope="col">Tạm tính</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                    <tr class="cart-item" data-cart-item="{{ data_get($item, 'uuid') }}">
                        <td class="cart-item__media">
                            <div class="cart-item__image-container gradient global-media-settings">
                                <img src="{{ data_get($item, 'inventory.image') }}" class="cart-item__image" alt="{{ data_get($item, 'inventory.title') }}" loading="lazy" width="150" height="150">
                            </div>
                        </td>
                        <td class="cart-item__details">
                            <a href="{{ route('fe.web.products.index', data_get($item, 'inventory.slug')) }}" class="cart-item__name h4 break">{{ data_get($item, 'inventory.title') }}</a>
                            <div class="product-option" data-value-cart-item-price>{{ format_price(data_get($item, 'price')) }}</div>
                            <dl>
                                @php
                                    $attributeValues = data_get($item, 'inventory.attributeValues')->pluck('value', 'attribute_id')->toArray();
                                @endphp
                                @foreach (data_get($item, 'inventory.attributes', []) as $attribute)
                                <div class="product-option">
                                    <dt>{{ data_get($attribute, 'name') }}: </dt>
                                    <dd>{{ data_get($attributeValues, [data_get($attribute, 'id')]) }}</dd>
                                </div>
                                @endforeach
                            </dl>
                        </td>
                        <td class="cart-item__totals right medium-hide large-up-hide">
                            <div class="loading-overlay hidden">
                                <div class="loading-overlay__spinner">
                                    <svg focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                                        <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                                    </svg>
                                </div>
                            </div>
                            <div class="cart-item__price-wrapper">
                                <span class="price price--end" data-value-cart-item-total-price>{{ format_price($item->total_price) }}</span>
                            </div>
                        </td>
                        <td class="cart-item__quantity">
                            <div class="cart-item__quantity-wrapper">
                                <label class="visually-hidden" for="Quantity-1"> Số lượng </label>
                                <quantity-input class="quantity" data-cart-id="{{ data_get($item, 'id') }}">
                                    <button data-quantity-decrease="cart_item_{{ data_get($item, 'id') }}" class="quantity__button no-js-hidden" name="minus" type="button">
                                        <span class="visually-hidden">Giảm số lượng cho {{ data_get($item, 'inventory.title') }}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" focusable="false" class="icon icon-minus" fill="none" viewBox="0 0 10 2">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M.5 1C.5.7.7.5 1 .5h8a.5.5 0 110 1H1A.5.5 0 01.5 1z" fill="currentColor"></path>
                                        </svg>
                                    </button>
                                    <input data-quantity-input="cart_item_{{ data_get($item, 'id') }}" class="quantity__input" type="number" name="updates[]" value="{{ data_get($item, 'quantity') }}" min="{{ data_get($item, 'inventory.min_order_quantity') }}" max="{{ data_get($item, 'inventory.stock_quantity') }}" data-index="1">
                                    <button data-quantity-increase="cart_item_{{ data_get($item, 'id') }}" class="quantity__button no-js-hidden" name="plus" type="button">
                                        <span class="visually-hidden">Tăng số lượng cho {{ data_get($item, 'inventory.title') }}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" focusable="false" class="icon icon-plus" fill="none" viewBox="0 0 10 10">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M1 4.51a.5.5 0 000 1h3.5l.01 3.5a.5.5 0 001-.01V5.5l3.5-.01a.5.5 0 00-.01-1H5.5L5.49.99a.5.5 0 00-1 .01v3.5l-3.5.01H1z" fill="currentColor"></path>
                                        </svg>
                                    </button>
                                </quantity-input>
                                <cart-remove-button data-index="1">
                                    <button type="button" cart-remove-button data-cart-id="{{ data_get($item, 'id') }}" class="button button--tertiary">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" focusable="false" class="icon icon-remove">
                                            <path d="M14 3h-3.53a3.07 3.07 0 00-.6-1.65C9.44.82 8.8.5 8 .5s-1.44.32-1.87.85A3.06 3.06 0 005.53 3H2a.5.5 0 000 1h1.25v10c0 .28.22.5.5.5h8.5a.5.5 0 00.5-.5V4H14a.5.5 0 000-1zM6.91 1.98c.23-.29.58-.48 1.09-.48s.85.19 1.09.48c.2.24.3.6.36 1.02h-2.9c.05-.42.17-.78.36-1.02zm4.84 11.52h-7.5V4h7.5v9.5z" fill="currentColor"></path>
                                            <path d="M6.55 5.25a.5.5 0 00-.5.5v6a.5.5 0 001 0v-6a.5.5 0 00-.5-.5zM9.45 5.25a.5.5 0 00-.5.5v6a.5.5 0 001 0v-6a.5.5 0 00-.5-.5z" fill="currentColor"></path>
                                        </svg>
                                    </button>
                                </cart-remove-button>
                            </div>
                            <div class="cart-item__error" id="Line-item-error-1">
                                <small class="cart-item__error-text"></small>
                                <svg focusable="false" class="icon icon-error" viewBox="0 0 13 13">
                                    <circle cx="6.5" cy="6.50049" r="5.5" stroke="white" stroke-width="2"></circle>
                                    <circle cx="6.5" cy="6.5" r="5.5" fill="#EB001B" stroke="#EB001B" stroke-width="0.7"></circle>
                                    <path d="M5.87413 3.52832L5.97439 7.57216H7.02713L7.12739 3.52832H5.87413ZM6.50076 9.66091C6.88091 9.66091 7.18169 9.37267 7.18169 9.00504C7.18169 8.63742 6.88091 8.34917 6.50076 8.34917C6.12061 8.34917 5.81982 8.63742 5.81982 9.00504C5.81982 9.37267 6.12061 9.66091 6.50076 9.66091Z" fill="white"></path>
                                    <path d="M5.87413 3.17832H5.51535L5.52424 3.537L5.6245 7.58083L5.63296 7.92216H5.97439H7.02713H7.36856L7.37702 7.58083L7.47728 3.537L7.48617 3.17832H7.12739H5.87413ZM6.50076 10.0109C7.06121 10.0109 7.5317 9.57872 7.5317 9.00504C7.5317 8.43137 7.06121 7.99918 6.50076 7.99918C5.94031 7.99918 5.46982 8.43137 5.46982 9.00504C5.46982 9.57872 5.94031 10.0109 6.50076 10.0109Z" fill="white" stroke="#EB001B" stroke-width="0.7"></path>
                                </svg>
                            </div>
                        </td>
                        <td class="cart-item__totals right small-hide">
                            <div class="loading-overlay hidden">
                                <div class="loading-overlay__spinner">
                                    <svg focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                                        <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                                    </svg>
                                </div>
                            </div>
                            <div class="cart-item__price-wrapper">
                                <span class="price price--end" data-value-cart-item-total-price>{{ format_price($item->total_price) }}</span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <p class="visually-hidden" id="cart-live-region-text"></p>
    <p class="visually-hidden" id="shopping-cart-line-item-status">Loading...</p>
</div>
