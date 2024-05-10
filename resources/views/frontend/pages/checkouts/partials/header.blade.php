<div class="wrap">
    <header>
        <a href="{{ route('fe.web.home') }}" class="s2kwpi1 _1frageme0 _1fragemlr _1fragemm0 s2kwpi3 _1fragemli _1fragemlm">
            <img
                src="{{ data_get($SYSTEM_SETTING, 'shop_logos.master.image') }}"
                srcset="{{ data_get($SYSTEM_SETTING, 'shop_logos.master.image') }}"
                alt="{{ data_get($SYSTEM_SETTING, 'page_settings.title') }}"
                style="width: {{ data_get($SYSTEM_SETTING, 'shop_logos.master.width', '180px') }}; height: {{ data_get($SYSTEM_SETTING, 'shop_logos.master.height', '38.89447236180904px') }}"
                class="header__heading-logo"
            >
        </a>
        <a id="cart-link" href="{{ route('fe.web.cart.index') }}">
            <svg class="icon icon-cart" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" fill="none" style="width: 50px; height: 50px; stroke: #fff;">
                <path fill="currentColor" fill-rule="evenodd" d="M20.5 6.5a4.75 4.75 0 00-4.75 4.75v.56h-3.16l-.77 11.6a5 5 0 004.99 5.34h7.38a5 5 0 004.99-5.33l-.77-11.6h-3.16v-.57A4.75 4.75 0 0020.5 6.5zm3.75 5.31v-.56a3.75 3.75 0 10-7.5 0v.56h7.5zm-7.5 1h7.5v.56a3.75 3.75 0 11-7.5 0v-.56zm-1 0v.56a4.75 4.75 0 109.5 0v-.56h2.22l.71 10.67a4 4 0 01-3.99 4.27h-7.38a4 4 0 01-4-4.27l.72-10.67h2.22z"></path>
            </svg>
        </a>
    </header>
</div>
