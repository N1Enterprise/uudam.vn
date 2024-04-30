<div class="mobile-sale-actions">
    <div class="product-form__buttons">
        <div class="product-sale-btn-groups">
            <div class="sale-action-item sale-action-cart">
                <a href="{{ route('fe.web.cart.index') }}" class="header__icon header__icon--cart link focus-inset">
                    <svg class="icon icon-cart" style="stroke: #025B50;" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" fill="none" style="width: 40px; height: 40px;">
                        <path fill="currentColor" fill-rule="evenodd" d="M20.5 6.5a4.75 4.75 0 00-4.75 4.75v.56h-3.16l-.77 11.6a5 5 0 004.99 5.34h7.38a5 5 0 004.99-5.33l-.77-11.6h-3.16v-.57A4.75 4.75 0 0020.5 6.5zm3.75 5.31v-.56a3.75 3.75 0 10-7.5 0v.56h7.5zm-7.5 1h7.5v.56a3.75 3.75 0 11-7.5 0v-.56zm-1 0v.56a4.75 4.75 0 109.5 0v-.56h2.22l.71 10.67a4 4 0 01-3.99 4.27h-7.38a4 4 0 01-4-4.27l.72-10.67h2.22z"></path>
                    </svg>
                    <span class="visually-hidden">Cart</span>
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
                <button mobile-sale-action-addtocart class="product-sale-btn-item product-sale-btn-add-to-cart product-form__submit button button--full-width button--primary" style="background-color: #fff; color: #000;">
                    <svg class="icon icon-cart" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" fill="none" style="width: 40px; height: 40px;">
                        <path fill="currentColor" fill-rule="evenodd" d="M20.5 6.5a4.75 4.75 0 00-4.75 4.75v.56h-3.16l-.77 11.6a5 5 0 004.99 5.34h7.38a5 5 0 004.99-5.33l-.77-11.6h-3.16v-.57A4.75 4.75 0 0020.5 6.5zm3.75 5.31v-.56a3.75 3.75 0 10-7.5 0v.56h7.5zm-7.5 1h7.5v.56a3.75 3.75 0 11-7.5 0v-.56zm-1 0v.56a4.75 4.75 0 109.5 0v-.56h2.22l.71 10.67a4 4 0 01-3.99 4.27h-7.38a4 4 0 01-4-4.27l.72-10.67h2.22z"></path>
                    </svg>
                    <span>Thêm Giỏ</span>
                    <div class="loading-overlay__spinner hidden">
                        <svg focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                            <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                        </svg>
                    </div>
                </button>
            </div>
            <div class="sale-action-item sale-action-buynow">
                <button mobile-sale-action-buynow type="button" id="buy_now" class="product-sale-btn-item product-sale-btn-buy-now product-form__submit button button--full-width button--primary" data-return-url="http://uudam.vn.test/checkout-confirmation" login-ref="#Add_Cart_Required_Login">
                    <span>Mua Ngay</span>
                </button>
            </div>
        </div>
    </div>
</div>
