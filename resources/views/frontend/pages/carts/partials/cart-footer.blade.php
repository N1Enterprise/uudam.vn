<div id="shopify-section-template--16599720296698__cart-footer" class="shopify-section cart__footer-wrapper">
    <div class="page-width" id="main-cart-footer" data-id="template--16599720296698__cart-footer">
        <div>
            <div class="cart__footer">
                <div class="cart__blocks">
                    <div class="js-contents">
                        <div class="totals">
                            <h2 class="totals__subtotal">Tổng tạm tính</h2>
                            <p class="totals__subtotal-value" data-value-cart-total-price>{{ format_price($cart->total_price) }}</p>
                        </div>
                        <div></div>
                    </div>
                    <div class="cart__ctas">
                        <button type="submit" id="checkout" class="cart__checkout-button button" name="checkout" form="cart"> Hoàn tất thanh toán </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
