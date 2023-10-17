<div class="product__info-container product__info-container--sticky">
    <div class="product__title">
        <h1 data-title>{{ $inventory->title }}</h1>
        <a href="/products/teaching-garden-buddha-statue" class="product__title">
            <h2 class="h1" data-title>{{ $inventory->title }}</h2>
        </a>
    </div>
    <div style="margin-top: -15px;">
        <p>SKU: <span data-sku>{{ $inventory->sku }}</span></p>
    </div>
    <p class="product__text subtitle"></p>
    <div class="no-js-hidden" role="status">
        <div class="price price--large price--show-badge">
            <div class="price__container">
                <div class="price__regular">
                    <span class="visually-hidden visually-hidden--inline">Giá Bán</span>
                    <span class="price-item price-item--regular" data-sale-price>{{ format_price($inventory->sale_price) }}</span>
                </div>
            </div>
            <span class="badge price__badge-sale color-accent-2">Giảm Giá</span>
            <span class="badge price__badge-sold-out color-inverse">Hết Hàng</span>
        </div>
    </div>
    <div>
        <form method="post" action="/cart/add" accept-charset="UTF-8" class="installment caption-large">
            <input type="hidden" name="form_type" value="product">
            <input type="hidden" name="utf8" value="✓">
            <input type="hidden" name="id" data-inventory-id value="{{ $inventory->id }}">
            <input type="hidden" name="product-id" value="{{ optional($inventory->product)->id }}">
        </form>
    </div>
    <div class="product-form__input product-form__quantity">
        <label class="form__label">{{ __('Số Lượng') }}</label>
        <quantity-input class="quantity">
            <button class="quantity__button no-js-hidden" name="minus" type="button">
                <span class="visually-hidden">Decrease quantity for Teaching Garden Buddha Statue</span>
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" role="presentation" class="icon icon-minus" fill="none" viewBox="0 0 10 2">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M.5 1C.5.7.7.5 1 .5h8a.5.5 0 110 1H1A.5.5 0 01.5 1z" fill="currentColor"></path>
                </svg>
            </button>
            <input data-stock-quantity class="quantity__input" type="number" name="quantity" min="1" value="1" max="{{ $inventory->stock_quantity }}">
            <button class="quantity__button no-js-hidden" name="plus" type="button">
                <span class="visually-hidden">Increase quantity for Teaching Garden Buddha Statue</span>
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" role="presentation" class="icon icon-plus" fill="none" viewBox="0 0 10 10">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M1 4.51a.5.5 0 000 1h3.5l.01 3.5a.5.5 0 001-.01V5.5l3.5-.01a.5.5 0 00-.01-1H5.5L5.49.99a.5.5 0 00-1 .01v3.5l-3.5.01H1z" fill="currentColor"></path>
                </svg>
            </button>
        </quantity-input>
    </div>
    <div>
        <product-form class="product-form">
            <div id="inventory_variants" data-variants='@json($variants)'></div>
            <div class="product-form__error-message-wrapper" role="alert" hidden="">
                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-error" viewBox="0 0 13 13">
                    <circle cx="6.5" cy="6.50049" r="5.5" stroke="white" stroke-width="2"></circle>
                    <circle cx="6.5" cy="6.5" r="5.5" fill="#EB001B" stroke="#EB001B" stroke-width="0.7"></circle>
                    <path d="M5.87413 3.52832L5.97439 7.57216H7.02713L7.12739 3.52832H5.87413ZM6.50076 9.66091C6.88091 9.66091 7.18169 9.37267 7.18169 9.00504C7.18169 8.63742 6.88091 8.34917 6.50076 8.34917C6.12061 8.34917 5.81982 8.63742 5.81982 9.00504C5.81982 9.37267 6.12061 9.66091 6.50076 9.66091Z" fill="white"></path>
                    <path d="M5.87413 3.17832H5.51535L5.52424 3.537L5.6245 7.58083L5.63296 7.92216H5.97439H7.02713H7.36856L7.37702 7.58083L7.47728 3.537L7.48617 3.17832H7.12739H5.87413ZM6.50076 10.0109C7.06121 10.0109 7.5317 9.57872 7.5317 9.00504C7.5317 8.43137 7.06121 7.99918 6.50076 7.99918C5.94031 7.99918 5.46982 8.43137 5.46982 9.00504C5.46982 9.57872 5.94031 10.0109 6.50076 10.0109Z" fill="white" stroke="#EB001B" stroke-width="0.7"></path>
                </svg>
                <span class="product-form__error-message"></span>
            </div>
            <div class="product-attributes">
                @foreach ($attributes as $attribute)
                <div class="attributes-item">
                    <label for="attribute_{{ $attribute->id }}">
                        <span class="attributes-item__name">{{ $attribute->name }}</span>
                        <input type="radio" name="attribute" id="attribute_{{ $attribute->id }}" class="d-none" value="{{ $attribute->id }}">
                    </label>
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
                </div>
                @endforeach
            </div>

            @include('frontend.pages.products.partials.included-products')

            <form method="post" action="/cart/add" accept-charset="UTF-8" class="form" enctype="multipart/form-data" novalidate="novalidate" data-type="add-to-cart-form">
                <input type="hidden" name="form_type" value="product">
                <input type="hidden" name="utf8" value="✓">
                <input type="hidden" name="id" value="{{ data_get($inventory, 'product.id') }}">
                <div class="product-form__buttons">
                    <button type="submit" name="add" class="product-form__submit button button--full-width button--primary">
                        <span>Thêm Vào Giỏ Hàng</span>
                        <div class="loading-overlay__spinner hidden">
                            <svg aria-hidden="true" focusable="false" role="presentation" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                                <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                            </svg>
                        </div>
                    </button>
                    </div>
                </div>
            </form>
        </product-form>
    </div>
    {{-- <div class="product__description rte quick-add-hidden">
        <div class="editorjs-parser" data-editorjs-content='@json(data_get($inventory, 'product.description'))'></div>
    </div> --}}
    <share-button class="share-button quick-add-hidden">
        <details>
            <summary class="share-button__button" role="button" aria-expanded="false">
                <svg width="13" height="12" viewBox="0 0 13 12" class="icon icon-share" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                    <path d="M1.625 8.125V10.2917C1.625 10.579 1.73914 10.8545 1.9423 11.0577C2.14547 11.2609 2.42102 11.375 2.70833 11.375H10.2917C10.579 11.375 10.8545 11.2609 11.0577 11.0577C11.2609 10.8545 11.375 10.579 11.375 10.2917V8.125" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.14775 1.27137C6.34301 1.0761 6.65959 1.0761 6.85485 1.27137L9.56319 3.9797C9.75845 4.17496 9.75845 4.49154 9.56319 4.6868C9.36793 4.88207 9.05135 4.88207 8.85609 4.6868L6.5013 2.33203L4.14652 4.6868C3.95126 4.88207 3.63468 4.88207 3.43942 4.6868C3.24415 4.49154 3.24415 4.17496 3.43942 3.9797L6.14775 1.27137Z" fill="currentColor"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.5 1.125C6.77614 1.125 7 1.34886 7 1.625V8.125C7 8.40114 6.77614 8.625 6.5 8.625C6.22386 8.625 6 8.40114 6 8.125V1.625C6 1.34886 6.22386 1.125 6.5 1.125Z" fill="currentColor"></path>
                </svg>Share
            </summary>
            <div class="share-button__fallback motion-reduce">
                <div class="field">
                    <span id="ShareMessage-template--16599720820986__main" class="share-button__message hidden" role="status"></span>
                    <input data-url type="text" class="field__input" id="url" value="{{ route('fe.web.products.show', $inventory->slug) }}" placeholder="Link" onclick="" readonly="">
                    <label class="field__label" for="url">Link</label>
                </div>
                <button class="share-button__close hidden no-js-hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" role="presentation" class="icon icon-close" fill="none" viewBox="0 0 18 17">
                        <path d="M.865 15.978a.5.5 0 00.707.707l7.433-7.431 7.579 7.282a.501.501 0 00.846-.37.5.5 0 00-.153-.351L9.712 8.546l7.417-7.416a.5.5 0 10-.707-.708L8.991 7.853 1.413.573a.5.5 0 10-.693.72l7.563 7.268-7.418 7.417z" fill="currentColor"></path>
                    </svg>
                    <span class="visually-hidden">Close share</span>
                </button>
                <button class="share-button__copy no-js-hidden">
                    <svg class="icon icon-clipboard" width="11" height="13" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" viewBox="0 0 11 13">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2 1a1 1 0 011-1h7a1 1 0 011 1v9a1 1 0 01-1 1V1H2zM1 2a1 1 0 00-1 1v9a1 1 0 001 1h7a1 1 0 001-1V3a1 1 0 00-1-1H1zm0 10V3h7v9H1z" fill="currentColor"></path>
                    </svg>
                    <span class="visually-hidden">Copy link</span>
                </button>
            </div>
        </details>
    </share-button>
</div>
