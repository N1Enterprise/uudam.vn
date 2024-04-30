<!DOCTYPE html>
<html lang="vi" class="js ls-gt-xs ls-lt-xl ls-sm ls-lt-md ls-lt-lg">
<head>
    <meta charset="utf-8" />
    <title>@yield('page_title', __($APP_NAME))</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-locale" content="{{ \App::currentLocale() }}">
    @if(data_get($SYSTEM_SETTING, 'dmca_site_verification'))
    <meta name='dmca-site-verification' content="{{ data_get($SYSTEM_SETTING, 'dmca_site_verification') }}" />
    @endif
    @foreach (data_get($SYSTEM_SETTING, 'shop_favicons', []) as $favicon)
    <link rel="icon" type="image/png" sizes="{{ data_get($favicon, 'sizes') }}" href="{{ data_get($favicon, 'image') }}">
    @endforeach
    @yield('page_seo')
    @yield('style')
    @stack('style_pages')
    @if (data_get($SYSTEM_SETTING, 'google_analytics_tag'))
    {!! data_get($SYSTEM_SETTING, 'google_analytics_tag') !!}
    @endif
</head>
<body class="gradient swym-ready swym-buttons-loaded">
    @include('frontend.layouts.partials.header.index')
    <main id="MainContent" class="content-for-layout focus-none" tabindex="-1">
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
    @if (! empty(data_get($SYSTEM_SETTING, 'zalo_widget_chat_sdk')))
    {!! data_get($SYSTEM_SETTING, 'zalo_widget_chat_sdk') !!}
    @endif

    <button id="backToTop" title="Back to top" class="btn-back-to-top button__back-to-top">
        <div class="icon-up">
            <svg height="15" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="#FFF">
                <path d="M416 352c-8.188 0-16.38-3.125-22.62-9.375L224 173.3l-169.4 169.4c-12.5 12.5-32.75 12.5-45.25 0s-12.5-32.75 0-45.25l192-192c12.5-12.5 32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25C432.4 348.9 424.2 352 416 352z"></path>
            </svg>
        </div>
        <strong>Lên Đầu</strong>
    </button>

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
