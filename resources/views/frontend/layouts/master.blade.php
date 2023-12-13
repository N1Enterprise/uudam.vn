<!DOCTYPE html>
<html lang="vi" class="js ls-gt-xs ls-lt-xl ls-sm ls-lt-md ls-lt-lg">
<head>
    <meta charset="utf-8" />
    <title>@yield('page_title', __($APP_NAME))</title>

    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-locale" content="{{ \App::currentLocale() }}">
    <meta property="og:site_name" content="{{ __($APP_NAME) }}">

    @foreach (data_get($PAGE_SETTINGS, 'favicon') as $favicon)
    <link rel="icon" type="image/png" sizes="{{ data_get($favicon, 'sizes') }}" href="{{ data_get($favicon, 'image') }}">
    @endforeach

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
    <script nomodule="">
        document.documentMode <= 11 && location.replace("/unsupported.html")
    </script>
    <!--end::Web font -->

    <!--begin::Page Vendor Styles -->
    <link href="{{ asset_with_version('backoffice/assets/vendors/general/sweetalert2/dist/sweetalert2.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset_with_version('backoffice/assets/vendors/general/toastr/build/toastr.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendor Styles -->

    <!--begin::Page Common Styles -->
    <link href="{{ asset_with_version('frontend/assets/css/common/reset.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset_with_version('frontend/assets/css/common/base.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset_with_version('frontend/assets/css/common/buddha-megamenu2.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset_with_version('frontend/assets/css/common/component-mega-menu.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset_with_version('frontend/assets/css/common/section-footer.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset_with_version('frontend/assets/css/common/component-menu-drawer.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset_with_version('frontend/assets/css/common/component-list-social.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset_with_version('frontend/assets/css/common/component-search.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset_with_version('frontend/assets/css/common/component-predictive-search.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset_with_version('frontend/assets/css/common/quick-add.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset_with_version('frontend/assets/css/common/main.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset_with_version('frontend/assets/css/common/component-cart-drawer.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset_with_version('frontend/assets/css/common/component-cart-items.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset_with_version('vendor/validate/styles.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Common Styles -->

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

        #admintopnav {
            position: relative;
            background: #1d2327;
            background-color: #1d2327;
            color: #c3c4c7;
            font-weight: 400;
            font-size: 13px;
            width: 100%;
            overflow: hidden;
            z-index: 4;
        }

        #admintopnav a.split.highlight {
            background-color: #04AA6D;
            color: #fff;
        }

        #admintopnav a.split {
            float: right;
        }

        #admintopnav a {
            float: left;
            color: #f2f2f2;
            text-align: center;
            text-decoration: none;
            padding: 4px 16px;
            display: flex;
            align-items: center;
        }

        #admintopnav a:hover {
            background-color: #04AA6D;
            color: #fff;
        }
    </style>
    <!--end::Layout Skins -->

    <!--start::Social authentication -->
    <style>
        .social-authentication .social-authentication__item {
            width: 60px;
            height: 60px;
            background-color: rgb(var(--color-background));
            border: 0.1rem solid rgba(var(--color-foreground), 0.1);
            border-radius: 50%;
            color: rgba(var(--color-foreground), 0.55);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            margin: 5px;
        }

        .social-authentication .social-authentication__item.facebook {
            background-color: #25479b;
        }

        .social-authentication__title {
            position: relative;
        }

        .social-authentication__title span {
            font-size: 15px;
            color: rgb(120, 120, 120);
            display: inline-block;
            background: rgb(255, 255, 255);
            padding: 0px 20px;
            position: relative;
            z-index: 2;
        }

        .social-authentication__title::before {
            content: "";
            width: 100%;
            height: 1px;
            background: rgb(242, 242, 242);
            position: absolute;
            left: 0px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1;
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

    <input type="hidden" data-bo-shared='@json([
        'bo_host' => config('app.url'),
        'app_id'  => config('app.app_id')
    ])'>

    @include('frontend.layouts.partials.footer.index')

    <script src="{{ asset_with_version('backoffice/js/vendors/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset_with_version('backoffice/assets/vendors/general/moment/min/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset_with_version('backoffice/assets/vendors/general/toastr/build/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset_with_version('backoffice/assets/vendors/general/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset_with_version('backoffice/assets/vendors/custom/theme/framework/vendors/sweetalert2/init.js') }}" type="text/javascript"></script>
    <script src="{{ asset_with_version('backoffice/assets/vendors/general/js-cookie/src/js.cookie.js') }}" type="text/javascript"></script>

    <script src="{{ asset_with_version('vendor/validate/jquery.validate.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset_with_version('vendor/validate/custom.js') }}" type="text/javascript"></script>

    <script src="{{ asset_with_version('frontend/assets/js/utils/helpers.js') }}" type="text/javascript"></script>
    <script src="{{ asset_with_version('frontend/assets/js/utils/constants.js') }}" type="text/javascript"></script>
    <script src="{{ asset_with_version('frontend/assets/js/common/main.js') }}" type="text/javascript"></script>
    <script src="{{ asset_with_version('frontend/assets/js/utils/router.js') }}" type="text/javascript"></script>

    <!--start:: Authentication -->
    <script src="{{ asset_with_version('frontend/bundle/js/authentication/index.min.js') }}" type="text/javascript"></script>
    <!--end:: Authentication -->

    @include('frontend.layouts.js-pages.menu-drawer')
    @include('frontend.layouts.js-pages.authentication')
    @include('frontend.layouts.js-pages.predictive-search')
    @include('frontend.layouts.js-pages.user-order-cart')

    @yield('js_script')
    @stack('js_pages')
</body>
</html>
