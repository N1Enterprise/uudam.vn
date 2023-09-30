<div id="shopify-section-header" class="shopify-section section-header">
    <div class="sticky-header header-wrapper color-background-1 gradient header-wrapper--border-bottom">
        <header class="header header--middle-left page-width header--has-menu">
            @include('frontend.layouts.parials.header.partials.header-drawer')
            <h1 class="header__heading">
                <a href="/" class="header__heading-link link link--text focus-inset">
                    <img src="{{ asset('frontend/images/demo/main-logo.png') }}" alt="DharmaCrafts | Meditation Supplis Since 1979" srcset="" width="180" height="38.89447236180904" class="header__heading-logo">
                </a>
            </h1>
            <nav class="header__inline-menu">
                <ul class="list-menu list-menu--inline horizontal-mega-menu">
                    <li class="buddha-menu-item">
                        <a href="/collections/cushions-and-benches" aria-label="Meditation Cushions" class="header__menu-item list-menu__item link mega-menu__link mega-menu__link--level-2">
                            <span class="mm-title">Meditation Cushions</span>
                        </a>
                    </li>

                    <li class="buddha-menu-item">
                        <a href="/collections/cushions-and-benches" aria-label="Statues" class="header__menu-item list-menu__item link mega-menu__link mega-menu__link--level-2">
                            <span class="mm-title">Statues</span>
                        </a>
                    </li>

                    <li class="buddha-menu-item">
                        <a href="/collections/cushions-and-benches" aria-label="Meditation Supplies" class="header__menu-item list-menu__item link mega-menu__link mega-menu__link--level-2">
                            <span class="mm-title">Meditation Supplies</span>
                        </a>
                    </li>

                    <li class="buddha-menu-item">
                        <a href="/collections/cushions-and-benches" aria-label="Yoga" class="header__menu-item list-menu__item link mega-menu__link mega-menu__link--level-2">
                            <span class="mm-title">Yoga</span>
                        </a>
                    </li>

                    <li class="buddha-menu-item">
                        <a href="/collections/cushions-and-benches" aria-label="Jewelry" class="header__menu-item list-menu__item link mega-menu__link mega-menu__link--level-2">
                            <span class="mm-title">Jewelry</span>
                        </a>
                    </li>

                    <li class="buddha-menu-item">
                        <a href="/collections/cushions-and-benches" aria-label="Wellness" class="header__menu-item list-menu__item link mega-menu__link mega-menu__link--level-2">
                            <span class="mm-title">Wellness</span>
                        </a>
                    </li>

                    <li class="buddha-menu-item">
                        <a href="/collections/cushions-and-benches" aria-label="Home & Garden" class="header__menu-item list-menu__item link mega-menu__link mega-menu__link--level-2">
                            <span class="mm-title">Home & Garden</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="header__icons">
                {{-- <a href="/account/login" class="header__icon header__icon--account link focus-inset small-hide">
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" role="presentation" class="icon icon-account" fill="none" viewBox="0 0 24 24" stroke="#000000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <span class="visually-hidden">Search</span>
                </a> --}}
                @include('frontend.layouts.parials.header.partials.details-modal')
                <a href="/account/login" class="header__icon header__icon--account link focus-inset small-hide">
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" role="presentation" class="icon icon-account" fill="none" viewBox="0 0 18 19">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6 4.5a3 3 0 116 0 3 3 0 01-6 0zm3-4a4 4 0 100 8 4 4 0 000-8zm5.58 12.15c1.12.82 1.83 2.24 1.91 4.85H1.51c.08-2.6.79-4.03 1.9-4.85C4.66 11.75 6.5 11.5 9 11.5s4.35.26 5.58 1.15zM9 10.5c-2.5 0-4.65.24-6.17 1.35C1.27 12.98.5 14.93.5 18v.5h17V18c0-3.07-.77-5.02-2.33-6.15-1.52-1.1-3.67-1.35-6.17-1.35z" fill="currentColor"></path>
                    </svg>
                    <span class="visually-hidden">Log in</span>
                </a>
                <a href="/cart" class="header__icon header__icon--cart link focus-inset" id="cart-icon-bubble">
                    <svg class="icon icon-cart-empty" aria-hidden="true" focusable="false" role="presentation" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" fill="none">
                        <path d="m15.75 11.8h-3.16l-.77 11.6a5 5 0 0 0 4.99 5.34h7.38a5 5 0 0 0 4.99-5.33l-.78-11.61zm0 1h-2.22l-.71 10.67a4 4 0 0 0 3.99 4.27h7.38a4 4 0 0 0 4-4.27l-.72-10.67h-2.22v.63a4.75 4.75 0 1 1 -9.5 0zm8.5 0h-7.5v.63a3.75 3.75 0 1 0 7.5 0z" fill="currentColor" fill-rule="evenodd"></path>
                    </svg>
                    <span class="visually-hidden">Cart</span>
                </a>
            </div>
        </header>
    </div>
</div>
