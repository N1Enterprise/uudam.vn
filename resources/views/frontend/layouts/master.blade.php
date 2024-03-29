<!DOCTYPE html>
<html lang="vi" class="js ls-gt-xs ls-lt-xl ls-sm ls-lt-md ls-lt-lg">
<head>
    <meta charset="utf-8" />
    <title>@yield('page_title', __($APP_NAME))</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-locale" content="{{ \App::currentLocale() }}">

    @foreach (data_get($SYSTEM_SETTING, 'shop_favicons', []) as $favicon)
    <link rel="icon" type="image/png" sizes="{{ data_get($favicon, 'sizes') }}" href="{{ data_get($favicon, 'image') }}">
    @endforeach

    @yield('page_seo')

    <!--begin::Page Vendor Styles -->
    <link href="{{ asset_with_version('backoffice/assets/vendors/general/sweetalert2/dist/sweetalert2.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset_with_version('backoffice/assets/vendors/general/toastr/build/toastr.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendor Styles -->

    <!--begin::Page Common Styles -->
    <link href="{{ asset_with_version('frontend/bundle/css/reset.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset_with_version('frontend/bundle/css/variable.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset_with_version('frontend/bundle/css/base.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset_with_version('frontend/bundle/css/buddha-megamenu2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset_with_version('frontend/bundle/css/component-mega-menu.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset_with_version('frontend/bundle/css/section-footer.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset_with_version('frontend/bundle/css/component-menu-drawer.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset_with_version('frontend/bundle/css/component-list-social.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset_with_version('frontend/bundle/css/component-search.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset_with_version('frontend/bundle/css/component-predictive-search.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset_with_version('frontend/bundle/css/quick-add.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset_with_version('frontend/bundle/css/main.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset_with_version('frontend/bundle/css/mobile-menu.min.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Common Styles -->

    @yield('style_datatable')
    @yield('style')
    @stack('style_pages')
    @include('frontend.layouts.css-layouts.master')

    @if (data_get($SYSTEM_SETTING, 'google_analytics_tag'))
    {!! data_get($SYSTEM_SETTING, 'google_analytics_tag') !!}
    @endif
</head>

<body class="gradient swym-ready swym-buttons-loaded">
    @include('frontend.layouts.partials.header.index')

    <main id="MainContent" class="content-for-layout focus-none" role="main" tabindex="-1">
        @yield('content_body')
        @stack('modals')
    </main>

    <input type="hidden" data-bo-shared='@json($CONSTANTS_SHARED)'>
    <input type="hidden" data-canprocessasthesame="{{ !empty($AUTHENTICATED_USER) }}" data-authenticated-user='@json($AUTHENTICATED_USER)'>

    @if (data_get($SYSTEM_SETTING, 'receive_new_post_setting.enable'))
    @include('frontend.layouts.partials.footer.subscribe')
    @endif

    @include('frontend.layouts.partials.footer.index')
    @include('frontend.layouts.partials.menu-mobile.index')

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

    <script src="{{ asset_with_version('frontend/bundle/js/app.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset_with_version('frontend/bundle/js/authentication.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset_with_version('frontend/bundle/js/menu-drawer.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset_with_version('frontend/bundle/js/predictive-search.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset_with_version('frontend/bundle/js/user-order-cart.min.js') }}" type="text/javascript"></script>

    @yield('js_script')
    @stack('js_pages')
</body>
</html>
