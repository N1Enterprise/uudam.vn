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
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14" focusable="false">
                    <path d="M2.675 10.037 3.072 4.2h7.856l.397 5.837A2.4 2.4 0 0 1 8.931 12.6H5.069a2.4 2.4 0 0 1-2.394-2.563Z"></path>
                    <path d="M4.9 3.5a2.1 2.1 0 1 1 4.2 0v1.4a2.1 2.1 0 0 1-4.2 0V3.5Z"></path>
                </svg>
            </span>
        </a>
    </header>
</div>
