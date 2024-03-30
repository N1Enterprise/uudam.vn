<cart-items class="page-width is-empty">
    <div class="title-wrapper-with-link">
        <h1 class="title title--primary">Giỏ hàng của bạn</h1>
        <a href="{{ route('fe.web.home') }}" class="underlined-link">Tiếp tục mua hàng</a>
    </div>
    <div class="cart__warnings">
        <h1 class="cart__empty-text">Không có sản phẩm trong giỏ hàng</h1>
        <a href="{{ route('fe.web.home') }}" class="button"> Tiếp tục mua hàng </a>

        @if(empty($AUTHENTICATED_USER))
        <h2 class="cart__login-title">Bạn có tài khoản chưa?</h2>
        <p class="cart__login-paragraph">
            <p>Bạn cần <a id="Add_Cart_Required_Login" class="link underlined-link" href="?overlay=signin" data-redirect="{{ request()->url() }}" data-overlay-action-button="signin">Đăng nhập</a> để kiểm tra nhanh hơn.</p>
        </p>
        @endif
    </div>
    <form action="/cart" class="cart__contents critical-hidden" method="post" id="cart">
        <div class="cart__items" id="main-cart-items" data-id="template--16599720296698__cart-items">
            <div class="js-contents"></div>
        </div>
        <p class="visually-hidden" id="cart-live-region-text" role="status"></p>
        <p class="visually-hidden" id="shopping-cart-line-item-status" role="status">Loading...</p>
    </form>
</cart-items>
