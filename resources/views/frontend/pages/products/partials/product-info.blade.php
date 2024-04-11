<div class="product__info-container product__info-container--sticky" data-inventory='@json($inventory)'>
    <div class="product__title">
        <h1 data-title>{{ $inventory->title }}</h1>
    </div>
    <div style="display: flex; justify-content: space-between; align-items: center; margin: 3px 0; margin: -10px 0;">
        <div>SKU: <span data-sku>{{ $inventory->sku }}</span></div>
        @if (($inventory->final_sold_count))
        <div style="font-size: 15px;">Đã bán {{ $inventory->final_sold_count }}</div>
        @endif
    </div>
    @if ($inventory->isOngoingFlashSale())
    @include('frontend.pages.products.partials.flash-sale')
    @endif
    <p class="product__text subtitle"></p>
    <div class="{{ $inventory->isOngoingFlashSale() ? 'flashsale-price' : '' }}">
        <div class="price price--large price--show-badge">
            <div class="price__container">
                <div class="price__regular">
                    <span class="visually-hidden visually-hidden--inline">Giá Bán</span>
                    <span class="price-item price-item--regular" data-price-value="{{ data_get($inventory, 'final_price') }}" data-sale-price>{{ format_price(data_get($inventory, 'final_price')) }}</span>
                    @if ($inventory->has_offer_price)
                    <del class="price-item--sub">{{ format_price(data_get($inventory, 'sub_price')) }}</del>
                    <span class="price-discount-percent">-{{ get_percent(data_get($inventory, 'final_price'), data_get($inventory, 'sub_price')) }}%</span>
                    <div class="price-for-saving">(Tiết kiệm <span>{{ format_price( (float) data_get($inventory, 'sub_price') - (float) data_get($inventory, 'final_price') ) }}</span>)</div>
                    @endif
                </div>
            </div>
            <span class="badge price__badge-sale color-accent-2">Giảm Giá</span>
            <span class="badge price__badge-sold-out color-inverse">Hết Hàng</span>
        </div>
    </div>

    @if (has_data($inventory->condition_note))
    <div class="product-condition-note">{!! $inventory->condition_note !!}</div>
    @endif

    @if (has_data(data_get($inventory, 'key_features', [])))
    <div class="product-promotion rounded-sm" id="ega-salebox">
        <h3 class="product-promotion__heading" style="display: flex; align-items: center;">
            <img src="{{ asset_with_version('frontend/assets/images/icons/icon-product-promotion.webp') }}" alt="{{ $inventory->title }}" width="22" height="22" style="margin-right: 7px; margin-bottom: 2px;">
            CAM KẾT - CHẤT LƯỢNG - AN TOÀN
        </h3>
        <ul class="promotion-box">
            @foreach (data_get($inventory, 'key_features', []) as $keyFeature)
            <li>{{ data_get($keyFeature, 'title') }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div>
        <form method="post" action="" form-add-to-cart accept-charset="UTF-8" class="installment caption-large">
            <input type="hidden" name="form_type" value="product">
            <input type="hidden" name="utf8" value="✓">
            <input type="hidden" name="id" data-inventory-id value="{{ $inventory->id }}">
            <input type="hidden" name="product-id" value="{{ optional($inventory->product)->id }}">
        </form>
    </div>

    <div>
        <product-form class="product-form">
            <div id="inventory_variants" data-variants='@json($variants->toArray())'></div>
            <div class="product-form__error-message-wrapper" hidden="">
                <svg focusable="false" class="icon icon-error" viewBox="0 0 13 13">
                    <circle cx="6.5" cy="6.50049" r="5.5" stroke="white" stroke-width="2"></circle>
                    <circle cx="6.5" cy="6.5" r="5.5" fill="#EB001B" stroke="#EB001B" stroke-width="0.7"></circle>
                    <path d="M5.87413 3.52832L5.97439 7.57216H7.02713L7.12739 3.52832H5.87413ZM6.50076 9.66091C6.88091 9.66091 7.18169 9.37267 7.18169 9.00504C7.18169 8.63742 6.88091 8.34917 6.50076 8.34917C6.12061 8.34917 5.81982 8.63742 5.81982 9.00504C5.81982 9.37267 6.12061 9.66091 6.50076 9.66091Z" fill="white"></path>
                    <path d="M5.87413 3.17832H5.51535L5.52424 3.537L5.6245 7.58083L5.63296 7.92216H5.97439H7.02713H7.36856L7.37702 7.58083L7.47728 3.537L7.48617 3.17832H7.12739H5.87413ZM6.50076 10.0109C7.06121 10.0109 7.5317 9.57872 7.5317 9.00504C7.5317 8.43137 7.06121 7.99918 6.50076 7.99918C5.94031 7.99918 5.46982 8.43137 5.46982 9.00504C5.46982 9.57872 5.94031 10.0109 6.50076 10.0109Z" fill="white" stroke="#EB001B" stroke-width="0.7"></path>
                </svg>
                <span class="product-form__error-message"></span>
            </div>
            @if(count($attributes))
            <variant-radios style="margin-top: 10px;">
                @foreach ($attributes as $attribute)
                <fieldset class="attributes-item product-form__input">
                    <legend for="attribute_{{ $attribute->id }}" class="form__label">
                        <span>{{ $attribute->name }}</span>
                        <input type="radio" name="attribute" id="attribute_{{ $attribute->id }}" class="d-none" value="{{ $attribute->id }}">
                    </legend>
                    <div class="attributes-values">
                        @foreach ($attribute->attributeValues as $value)
                        <div class="attributes-values-item">
                            <label class="label {{ in_array($value->id, $inventoryAttributes) ? 'active' : '' }}">
                                <span>{{ $value->value }}</span>
                                <input
                                    type="radio"
                                    {{ in_array($value->id, $inventoryAttributes) ? 'checked' : '' }}
                                    data-attribute-id="{{ $attribute->id }}"
                                    data-order="{{ $value->order }}"
                                    name="attribute_value"
                                    class="d-none"
                                    value="{{ $value->id }}"
                                >
                            </label>
                        </div>
                        @endforeach
                    </div>
                </fieldset>
                @endforeach
            </variant-radios>
            @endif

            @if (has_data(data_get($inventory, 'productCombos', [])))
            @include('frontend.pages.products.partials.product-combos')
            @endif

            <div class="inventory-price-area" style="padding: 15px 0;">
                <div class="product-form__input product-form__quantity">
                    <label class="form__label">{{ __('Số Lượng') }}</label>
                    <quantity-input class="quantity">
                        <button data-quantity-decrease="product" class="quantity__button no-js-hidden" name="minus" type="button" data-quantity-button="decrease">
                            <span class="visually-hidden">Decrease quantity for {{ $inventory->title }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" focusable="false" class="icon icon-minus" fill="none" viewBox="0 0 10 2">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M.5 1C.5.7.7.5 1 .5h8a.5.5 0 110 1H1A.5.5 0 01.5 1z" fill="currentColor"></path>
                            </svg>
                        </button>
                        <input data-quantity-input="product" data-stock-quantity class="quantity__input" type="number" name="quantity" min="1" value="1" max="{{ $inventory->stock_quantity }}">
                        <button data-quantity-increase="product" class="quantity__button no-js-hidden" name="plus" type="button" data-quantity-button="increase">
                            <span class="visually-hidden">Increase quantity for {{ $inventory->title }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" focusable="false" class="icon icon-plus" fill="none" viewBox="0 0 10 10">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1 4.51a.5.5 0 000 1h3.5l.01 3.5a.5.5 0 001-.01V5.5l3.5-.01a.5.5 0 00-.01-1H5.5L5.49.99a.5.5 0 00-1 .01v3.5l-3.5.01H1z" fill="currentColor"></path>
                            </svg>
                        </button>
                    </quantity-input>
                </div>
                <div>
                    <div class="inventory-price">
                        <label for="" data-total-cart-label>Tạm tính</label>:
                        <b class="total-cart" data-total-cart-price>{{ format_price(data_get($inventory, 'final_price')) }}</b>
                    </div>
                </div>
            </div>

            @if(empty($AUTHENTICATED_USER))
            <p style="font-size: 1.4rem;">Bạn cần <a id="Add_Cart_Required_Login" href="?overlay=signin" class="link" data-redirect="{{ request()->url() }}" data-overlay-action-button="signin">Đăng nhập</a> trước khi mua hàng</p>
            @endif

            <form method="post" login-ref="#Add_Cart_Required_Login" form-add-to-cart accept-charset="UTF-8" class="form" novalidate="novalidate">
                <input type="hidden" name="form_type" value="product">
                <input type="hidden" name="utf8" value="✓">
                <input type="hidden" name="product_id" data-value="{{ data_get($inventory, 'product.id') }}" value="{{ data_get($inventory, 'product.id') }}">
                <input type="hidden" name="inventory_id" value="{{ data_get($inventory, 'id') }}">
                <input type="hidden" name="quantity" value="1">
                <input type="hidden" name="has_combo" value="0">
                <div class="product-form__buttons">
                    @if (has_data($affiliateSalesChannels) && has_data(data_get($inventory, 'sale_channels')))
                    <div class="affiliate_Sales_Channels">
                        @foreach ($affiliateSalesChannels as $channel)
                            @if (data_get($inventory, ['sale_channels', data_get($channel, 'key')]))
                            <a href="{{ data_get($inventory, ['sale_channels', data_get($channel, 'key')]) }}" target="_blank" class="affiliate_Sales_Channels__item">
                                <img src="{{ data_get($channel, 'logo') }}" alt="{{ data_get($channel, 'name') }}" width="30" height="30">
                                <span>Mua tại {{ data_get($channel, 'name') }}</span>
                            </a>
                            @endif
                        @endforeach
                    </div>
                    @endif

                    <div style="display: flex; justify-content: space-between;">
                        <a class="link" href="{{ route('fe.web.cart.index') }}" style="margin-bottom: 1rem; border: 1px solid #ccc; display: flex; align-items: center; justify-content: center; text-decoration: none; width: 50px; height: 50px; position: relative;" title="Xem giỏ hàng">
                            <svg class="icon icon-cart" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" fill="none" style="width: 40px; height: 40px;">
                                <path fill="currentColor" fill-rule="evenodd" d="M20.5 6.5a4.75 4.75 0 00-4.75 4.75v.56h-3.16l-.77 11.6a5 5 0 004.99 5.34h7.38a5 5 0 004.99-5.33l-.77-11.6h-3.16v-.57A4.75 4.75 0 0020.5 6.5zm3.75 5.31v-.56a3.75 3.75 0 10-7.5 0v.56h7.5zm-7.5 1h7.5v.56a3.75 3.75 0 11-7.5 0v-.56zm-1 0v.56a4.75 4.75 0 109.5 0v-.56h2.22l.71 10.67a4 4 0 01-3.99 4.27h-7.38a4 4 0 01-4-4.27l.72-10.67h2.22z"></path>
                            </svg>
                            <div class="cart-count-bubble">
                                <span>
                                    <span data-value-cart-total-quantity="">0</span>
                                </span>
                                <span class="visually-hidden">
                                    <span data-value-cart-total-quantity="">0</span>
                                    item
                                </span>
                            </div>
                        </a>
                        <button type="button" id="buy_now" class="product-form__submit button button--full-width button--primary" data-return-url="{{ route('fe.web.user.checkout.confirmation') }}" login-ref="#Add_Cart_Required_Login" style="flex: 1; margin-left: 10px;">
                            <span>Mua ngay</span>
                        </button>
                    </div>

                    <button type="submit" name="add" class="product-form__submit button button--full-width button--primary" style="background-color: #fff; color: #000;">
                        <span>Thêm vào giỏ hàng</span>
                        <div class="loading-overlay__spinner hidden">
                            <svg focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                                <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                            </svg>
                        </div>
                    </button>
                </div>
            </form>

        </product-form>
    </div>
    <share-button class="share-button quick-add-hidden">
        <details>
            <summary class="share-button__button">
                <svg width="13" height="12" viewBox="0 0 13 12" class="icon icon-share" fill="none" xmlns="http://www.w3.org/2000/svg" focusable="false">
                    <path d="M1.625 8.125V10.2917C1.625 10.579 1.73914 10.8545 1.9423 11.0577C2.14547 11.2609 2.42102 11.375 2.70833 11.375H10.2917C10.579 11.375 10.8545 11.2609 11.0577 11.0577C11.2609 10.8545 11.375 10.579 11.375 10.2917V8.125" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.14775 1.27137C6.34301 1.0761 6.65959 1.0761 6.85485 1.27137L9.56319 3.9797C9.75845 4.17496 9.75845 4.49154 9.56319 4.6868C9.36793 4.88207 9.05135 4.88207 8.85609 4.6868L6.5013 2.33203L4.14652 4.6868C3.95126 4.88207 3.63468 4.88207 3.43942 4.6868C3.24415 4.49154 3.24415 4.17496 3.43942 3.9797L6.14775 1.27137Z" fill="currentColor"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.5 1.125C6.77614 1.125 7 1.34886 7 1.625V8.125C7 8.40114 6.77614 8.625 6.5 8.625C6.22386 8.625 6 8.40114 6 8.125V1.625C6 1.34886 6.22386 1.125 6.5 1.125Z" fill="currentColor"></path>
                </svg>Chia Sẻ
            </summary>
            <div class="share-button__fallback motion-reduce">
                <div class="field">
                    <span class="share-button__message hidden"></span>
                    <input data-url type="text" class="field__input" id="url" value="{{ route('fe.web.products.index', $inventory->slug) }}" placeholder="Link" onclick="" readonly="">
                    <label class="field__label" for="url">Link</label>
                </div>
                <button class="share-button__close hidden no-js-hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" focusable="false" class="icon icon-close" fill="none" viewBox="0 0 18 17">
                        <path d="M.865 15.978a.5.5 0 00.707.707l7.433-7.431 7.579 7.282a.501.501 0 00.846-.37.5.5 0 00-.153-.351L9.712 8.546l7.417-7.416a.5.5 0 10-.707-.708L8.991 7.853 1.413.573a.5.5 0 10-.693.72l7.563 7.268-7.418 7.417z" fill="currentColor"></path>
                    </svg>
                    <span class="visually-hidden">Close share</span>
                </button>
                <button class="share-button__copy no-js-hidden">
                    <svg class="icon icon-clipboard" width="11" height="13" fill="none" xmlns="http://www.w3.org/2000/svg" focusable="false" viewBox="0 0 11 13">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2 1a1 1 0 011-1h7a1 1 0 011 1v9a1 1 0 01-1 1V1H2zM1 2a1 1 0 00-1 1v9a1 1 0 001 1h7a1 1 0 001-1V3a1 1 0 00-1-1H1zm0 10V3h7v9H1z" fill="currentColor"></path>
                    </svg>
                    <span class="visually-hidden">Copy link</span>
                </button>
            </div>
        </details>
    </share-button>
</div>
