<!DOCTYPE html>
<html lang="en" class="js ls-gt-xs ls-lt-xl ls-sm ls-lt-md ls-lt-lg">

<head>
    <meta charset="utf-8" />
    <title> @yield('page_title', __($APP_NAME))</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-locale" content="{{ \App::currentLocale() }}">
    <meta property="og:site_name" content="{{ __($APP_NAME) }}">

    @yield('page_seo')

    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Poppins:300,400,500,600,700"]
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!--end::Web font -->

    <!--begin::Page Vendors Styles -->
    <link href="{{ asset('frontend/assets/css/common/reset.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('frontend/assets/css/common/base.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backoffice/assets/vendors/general/toastr/build/toastr.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('frontend/assets/css/common/buddha-megamenu2.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('frontend/assets/css/common/component-mega-menu.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('frontend/assets/css/common/section-footer.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('frontend/assets/css/common/component-menu-drawer.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('frontend/assets/css/common/component-list-social.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('frontend/assets/css/common/component-search.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('frontend/assets/css/common/component-predictive-search.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('frontend/assets/css/common/quick-add.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('frontend/assets/css/common/main.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('frontend/assets/css/common/component-cart-drawer.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('frontend/assets/css/common/component-cart-items.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendors Styles -->

    @yield('style_datatable')
    @yield('style')
    @stack('style_pages')

    <style>
        @media screen and (min-width: 990px) {
            .modal-authentication .quick-add-modal__content {
                width: 40%;
            }
        }
    </style>

    <style>
        header-drawer {
            justify-self: start;
            margin-left: -1.2rem;
        }
        @media  screen and (min-width: 990px) {
            header-drawer {
            display: none;
        }
        }
        ul.mm-submenu {
            border: 0!important;
            text-transform: none;
            padding: 0!important;
            top: -99999px!important;
            margin: 0!important;
            position: absolute!important;
            list-style: none;
            width: auto;
            background: #fff;
            box-shadow: 0 0 20px rgba(0,0,0,.1)!important;
            font-family: "Helvetica Neue",Helvetica,Arial;
            font-weight: 400;
            line-height: normal;
            white-space: initial;
            height: auto;
            visibility: visible!important;
            opacity: 1;
            overflow: visible;
            z-index: 1000000!important;
            display: block!important;
            pointer-events: auto!important;
        }
        .horizontal-mega-menu ul.mm-submenu, .horizontal-mega-menu>li>ul.mm-submenu.tabbed>li>ul.mm-submenu li, .horizontal-mega-menu li.app-menu-item:hover ul.mm-submenu.simple li:hover, .horizontal-mega-menu li.app-menu-item.mega-hover ul.mm-submenu.simple li:hover {
            background: #ffffff !important;
        }
        .horizontal-mega-menu ul.mm-submenu, .horizontal-mega-menu ul.mm-submenu li, .horizontal-mega-menu ul.mm-submenu li.mm-contact-column span, .horizontal-mega-menu ul.mm-submenu li a, .horizontal-mega-menu ul.mm-submenu li a span, .horizontal-mega-menu ul.mm-submenu li.fa, .horizontal-mega-menu ul.mm-submenu.tree li:hover>a[data-href="no-link"], .horizontal-mega-menu ul.mm-submenu.tree li.mega-hover>a[data-href="no-link"], .horizontal-mega-menu ul.mm-submenu.tabbed>li.tab-opened>a[data-href="no-link"], .horizontal-mega-menu ul.mm-submenu li a[data-href="no-link"]:hover {
            color: #222222 !important;
        }
        .horizontal-mega-menu ul.mm-submenu, .horizontal-mega-menu ul.mm-submenu a, .horizontal-mega-menu ul.mm-submenu a>span, .horizontal-mega-menu ul.mm-submenu .money {
            font-size: 13px !important;
        }
        .vertical-mega-menu>.app-menu-item>.mm-submenu.height-transition {
            background-color: #017b86 !important;
        }
        .vertical-mega-menu[menuIdx="0"]>li.app-menu-item ul.mm-submenu.simple>li.mm-left-item {
            padding-left: 32px !important;
        }
        .vertical-mega-menu[menuIdx="0"]>li.app-menu-item ul.mm-submenu.simple>li.mm-right-item {
            padding-right: 32px !important;
        }
        .vertical-mega-menu ul.mm-submenu.simple > li .mm-list-name {
            border-bottom: 1px solid #ffffff !important;
        }
        .vertical-mega-menu ul.mm-submenu, .vertical-mega-menu ul.mm-submenu li.mm-contact-column span, .vertical-mega-menu ul.mm-submenu li a, .vertical-mega-menu ul.mm-submenu span, .vertical-mega-menu ul.mm-submenu>li>a>.toggle-menu-btn>.fa {
            color: #ffffff !important;
        }
        .vertical-mega-menu ul.mm-submenu, .vertical-mega-menu ul.mm-submenu span, .vertical-mega-menu ul.mm-submenu.simple>li ul.mm-product-list>li .mm-list-info {
            font-size: 13px !important;
        }
        .vertical-mega-menu ul.mm-submenu.simple > li .mm-list-name {
            border-bottom: 1px solid #ffffff !important;
        }
        .vertical-mega-menu ul.mm-submenu, .vertical-mega-menu ul.mm-submenu li.mm-contact-column span, .vertical-mega-menu ul.mm-submenu li a, .vertical-mega-menu ul.mm-submenu span, .vertical-mega-menu ul.mm-submenu>li>a>.toggle-menu-btn>.fa {
            color: #ffffff !important;
        }
        .vertical-mega-menu ul.mm-submenu, .vertical-mega-menu ul.mm-submenu span, .vertical-mega-menu ul.mm-submenu.simple>li ul.mm-product-list>li .mm-list-info {
            font-size: 13px !important;
        }
        .vertical-mega-menu[menuIdx="0"]>li.app-menu-item > a > .toggle-menu-btn {
            right: 32px !important;
            top: calc(50% + 0px) !important;
        }
    </style>
    <!--end::Layout Skins -->
</head>

<body class="gradient swym-ready swym-buttons-loaded">
    @include('frontend.layouts.partials.header.index')

    <main id="MainContent" class="content-for-layout focus-none" role="main" tabindex="-1">
        @yield('content_body')
        @stack('modals')
    </main>

    @include('frontend.layouts.partials.footer.index')

    {{-- @include('frontend.layouts.partials.cart-drawer.index') --}}

    <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.5/dist/js.cookie.min.js"></script>
    <script src="{{ asset('frontend/assets/js/utils/constants.js') }}" type="text/javascript"></script>
    <script src="{{ asset('backoffice/js/vendors/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('backoffice/assets/vendors/general/moment/min/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('backoffice/assets/vendors/general/toastr/build/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('frontend/assets/js/utils/helpers.js') }}" type="text/javascript"></script>
    <script src="{{ asset('frontend/assets/js/common/main.js') }}" type="text/javascript"></script>
    <script src="{{ asset('backoffice/assets/vendors/general/editorjs-parser/build/Parser.browser.js') }}" type="text/javascript"></script>

    @include('frontend.layouts.js-pages.menu-drawer')
    @include('frontend.layouts.js-pages.authentication')
    @include('frontend.layouts.js-pages.predictive-search')
    @include('frontend.layouts.js-pages.user-order-cart')

    @yield('js_script')
    @stack('js_pages')
</body>
</html>
