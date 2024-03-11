@include('frontend.layouts.partials.header.partials.admintopnav')

<div id="shopify-section-header" class="shopify-section section-header">
    <sticky-header class="header-wrapper color-background-1 gradient header-wrapper--border-bottom">
        <header class="header header--middle-left page-width header--has-menu">
            <header-drawer data-breakpoint="tablet">
                <details
                    id="Details-menu-drawer-container"
                    class="menu-drawer-container menu-opening"
                    class="menu-drawer-container"
                >
                    <summary
                        class="header__icon header__icon--menu header__icon--summary link focus-inset"
                        aria-label="Menu"
                        role="button"
                        aria-controls="menu-drawer"
                    >
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" role="presentation" class="icon icon-hamburger" fill="none" viewBox="0 0 18 16">
                                <path d="M1 .5a.5.5 0 100 1h15.71a.5.5 0 000-1H1zM.5 8a.5.5 0 01.5-.5h15.71a.5.5 0 010 1H1A.5.5 0 01.5 8zm0 7a.5.5 0 01.5-.5h15.71a.5.5 0 010 1H1a.5.5 0 01-.5-.5z" fill="currentColor">
                                </path>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" role="presentation" class="icon icon-close" fill="none" viewBox="0 0 18 17">
                                <path d="M.865 15.978a.5.5 0 00.707.707l7.433-7.431 7.579 7.282a.501.501 0 00.846-.37.5.5 0 00-.153-.351L9.712 8.546l7.417-7.416a.5.5 0 10-.707-.708L8.991 7.853 1.413.573a.5.5 0 10-.693.72l7.563 7.268-7.418 7.417z" fill="currentColor">
                                </path>
                            </svg>
                        </span>
                    </summary>
                    <div id="menu-drawer" class="gradient menu-drawer motion-reduce" tabindex="-1">
                        <div class="menu-drawer__inner-container">
                            <div class="menu-drawer__navigation-container">
                                <nav class="menu-drawer__navigation">
                                    <ul class="menu-drawer__menu has-submenu list-menu vertical-mega-menu" role="list" menuidx="0">
                                        @foreach ($APP_MENU_AVAILABEL as $menuGroup)
                                        <li class="app-menu-item" itemid="PMu22">
                                            <a
                                                href="{{ data_get($menuGroup, 'redirect_url', 'javascript:void(0)') }}"
                                                aria-label="{{ data_get($menuGroup, 'name') }}"
                                                class="menu-drawer__menu-item list-menu__item link link--text"
                                            >
                                                <span class="mm-title">{{ data_get($menuGroup, 'name') }}</span>

                                                @if(has_data(data_get($menuGroup, 'menu_sub_groups', [])))
                                                <i class="mm-arrow mm-angle-down" aria-hidden="true"></i>
                                                <span class="toggle-menu-btn fa-visible" style="display:none;" title="Toggle menu">
                                                    <span class="mm-arrow-icon">
                                                        <span class="bar-one"></span>
                                                        <span class="bar-two"></span>
                                                    </span>
                                                </span>
                                                @endif
                                            </a>

                                            @if(has_data(data_get($menuGroup, 'menu_sub_groups', [])))
                                            <ul class="mm-submenu simple mm-last-level height-transition" style="left: auto; right: auto; width: auto !important; margin-bottom: 0px; max-height: 0px;" columns="1">
                                                @foreach (data_get($menuGroup, 'menu_sub_groups', []) as $menuSubGroup)
                                                <li submenu-columns="{{ data_get($menuSubGroup, 'params.submenu_columns') }}" item-type="{{ data_get($menuSubGroup, 'params.item_type') }}" style="z-index: 10;" class="mm-right-item mm-left-item">
                                                    <div class="mega-menu-item-container">
                                                        @if(! data_get($menuSubGroup, 'params.hide_name', false))
                                                        <div class="mm-list-name" style="height: 37px;">
                                                            <span>
                                                                <a href="{{ data_get($menuSubGroup, 'redirect_url') ?? 'javascript:void(0)' }}" class="mm-title" style="font-weight: 700!important;">{{ data_get($menuSubGroup, 'name') }}</a>
                                                            </span>
                                                        </div>
                                                        @endif

                                                        @if(has_data(data_get($menuSubGroup, 'menus', [])))
                                                        <ul class="mm-product-list mm-last-level">
                                                            @foreach (data_get($menuSubGroup, 'menus', []) as $menu)
                                                            @include('frontend.layouts.partials.header.partials.menu-'.data_get($menu, 'type'))
                                                            @endforeach
                                                        </ul>
                                                        @endif
                                                    </div>
                                                </li>
                                                @endforeach
                                            </ul>
                                            @endif
                                        </li>
                                        @endforeach
                                    </ul>
                                </nav>
                                <div class="menu-drawer__utility-links">
                                    @if(empty($AUTHENTICATED_USER))
                                    <a href="javascript:void(0);" class="menu-drawer__account link focus-inset h5" data-overlay-action-button="signin">
                                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" role="presentation" class="icon icon-account" fill="none" viewBox="0 0 18 19">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6 4.5a3 3 0 116 0 3 3 0 01-6 0zm3-4a4 4 0 100 8 4 4 0 000-8zm5.58 12.15c1.12.82 1.83 2.24 1.91 4.85H1.51c.08-2.6.79-4.03 1.9-4.85C4.66 11.75 6.5 11.5 9 11.5s4.35.26 5.58 1.15zM9 10.5c-2.5 0-4.65.24-6.17 1.35C1.27 12.98.5 14.93.5 18v.5h17V18c0-3.07-.77-5.02-2.33-6.15-1.52-1.1-3.67-1.35-6.17-1.35z" fill="currentColor">
                                            </path>
                                        </svg>
                                        Đăng nhập
                                    </a>
                                    @else
                                    <a href="{{ route('fe.web.user.profile') }}" class="menu-drawer__account link focus-inset h5">
                                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" role="presentation" class="icon icon-account" fill="none" viewBox="0 0 18 19">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6 4.5a3 3 0 116 0 3 3 0 01-6 0zm3-4a4 4 0 100 8 4 4 0 000-8zm5.58 12.15c1.12.82 1.83 2.24 1.91 4.85H1.51c.08-2.6.79-4.03 1.9-4.85C4.66 11.75 6.5 11.5 9 11.5s4.35.26 5.58 1.15zM9 10.5c-2.5 0-4.65.24-6.17 1.35C1.27 12.98.5 14.93.5 18v.5h17V18c0-3.07-.77-5.02-2.33-6.15-1.52-1.1-3.67-1.35-6.17-1.35z" fill="currentColor">
                                            </path>
                                        </svg>
                                        Tài khoản
                                    </a>
                                    @endif
                                    <ul class="list list-social list-unstyled" role="list">
                                        @foreach (data_get($SYSTEM_SETTING, 'social_networks', []) as $network)
                                        <li class="list-social__item">
                                            <a href="{{ data_get($network, 'link') }}" target="_blank" title="{{ data_get($network, 'tooltip') }}" class="link list-social__link">
                                                <img src="{{ data_get($network, 'icon.link') }}" alt="{{ data_get($network, 'name') }}" width="{{ data_get($network, 'icon.width') }}" height="{{ data_get($network, 'icon.height') }}">
                                                <span class="visually-hidden">{{ data_get($network, 'name') }}</span>
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </details>
            </header-drawer>

            <h1 class="header__heading">
                <a href="{{ route('fe.web.home') }}" class="header__heading-link link link--text focus-inset">
                    <img
                        src="{{ data_get($SYSTEM_SETTING, 'shop_logos.master.image') }}"
                        srcset="{{ data_get($SYSTEM_SETTING, 'shop_logos.master.image') }}"
                        alt="{{ data_get($SYSTEM_SETTING, 'page_settings.title') }}"
                        style="width: {{ data_get($SYSTEM_SETTING, 'shop_logos.master.width', '180px') }}; height: {{ data_get($SYSTEM_SETTING, 'shop_logos.master.height', '38.89447236180904px') }}"
                        class="header__heading-logo"
                    >
                </a>
            </h1>

            <nav class="header__inline-menu">
                <ul class="list-menu list-menu--inline horizontal-mega-menu" role="list">
                    @foreach ($APP_MENU_AVAILABEL as $menuGroup)
                    <li class="app-menu-item" itemid="menu_{{ data_get($menuGroup, 'id') }}">
                        <a
                            href="{{ data_get($menuGroup, 'redirect_url') ?? 'javascript:void(0)' }}"
                            aria-label="{{ data_get($menuGroup, 'name') }}"
                            class="header__menu-item list-menu__item link mega-menu__link mega-menu__link--level-2"
                        >
                            <span class="mm-title">{{ data_get($menuGroup, 'name') }}</span>

                            @if(has_data(data_get($menuGroup, 'menu_sub_groups', [])))
                            <i class="mm-arrow mm-angle-down" aria-hidden="true"></i>
                            <span class="toggle-menu-btn" style="display:none;" title="Toggle menu">
                                <span class="mm-arrow-icon">
                                    <span class="bar-one"></span>
                                    <span class="bar-two"></span>
                                </span>
                            </span>
                            @endif
                        </a>

                        @if(has_data(data_get($menuGroup, 'menu_sub_groups', [])))
                        <ul class="mm-submenu simple mm-last-level" style="width: 1500px !important; right: auto; max-width: none; min-width: 400px !important; max-height: none; overflow: hidden;" columns="5">
                            @foreach (data_get($menuGroup, 'menu_sub_groups', []) as $menuSubGroup)
                            <li submenu-columns="{{ data_get($menuSubGroup, 'params.submenu_columns') }}" item-type="{{ data_get($menuSubGroup, 'params.item_type') }}" style="z-index: 10; margin-bottom: 10px !important;">
                                <div class="mega-menu-item-container">
                                    @if(! data_get($menuSubGroup, 'params.hide_name', false))
                                    <div class="mm-list-name" style="height: 37px;">
                                        <span>
                                            <a href="{{ data_get($menuSubGroup, 'redirect_url') ?? 'javascript:void(0)' }}" class="mm-title" style="font-weight: 700!important;">{{ data_get($menuSubGroup, 'name') }}</a>
                                        </span>
                                    </div>
                                    @endif

                                    @if(has_data(data_get($menuSubGroup, 'menus', [])))
                                    <ul class="mm-product-list mm-last-level">
                                        @foreach (data_get($menuSubGroup, 'menus', []) as $menu)
                                            @include('frontend.layouts.partials.header.partials.menu-'.data_get($menu, 'type'))
                                        @endforeach
                                    </ul>
                                    @endif
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </nav>
            @include('frontend.layouts.partials.header.partials.header-icons')
        </header>
    </sticky-header>
</div>

@push('modals')
@include('frontend.layouts.partials.header.modals.authentication')
@endpush
