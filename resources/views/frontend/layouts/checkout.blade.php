<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Thanh toán - {{ data_get($SYSTEM_SETTING, 'page_settings.title') }}</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-locale" content="{{ \App::currentLocale() }}">
    <meta property="og:site_name" content="{{ __($APP_NAME) }}">

    @foreach (data_get($SYSTEM_SETTING, 'page_settings.favicon', []) as $favicon)
    <link rel="icon" type="image/png" sizes="{{ data_get($favicon, 'sizes') }}" href="{{ data_get($favicon, 'image') }}">
    @endforeach

    @yield('page_seo')

    <style>
        @media screen and (max-width: 750px) {
            .checkout-header-side-item {
                display: none;
            }
        }
    </style>
    
    <link href="{{ asset_with_version('backoffice/assets/vendors/general/toastr/build/toastr.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    <link href="{{ asset_with_version('frontend/bundle/css/latest-199.min.css') }}" rel="stylesheet" type="text/css" />
    <input type="hidden" data-bo-shared='@json($CONSTANTS_SHARED)'>
    <input type="hidden" data-canprocessasthesame="{{ !empty($AUTHENTICATED_USER) }}" data-authenticated-user='@json($AUTHENTICATED_USER)'>

    @yield('style')

    <div class="app">
        <div class="checkout-page">
            <div class="checkout-page-header page-width">
                @include('frontend.pages.checkouts.partials.header')
            </div>
            <div class="checkout-page-body flexbox">
                @yield('content_body')
            </div>
        </div>
    </div>

    <script src="{{ asset_with_version('backoffice/js/vendors/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset_with_version('frontend/assets/js/utils/helpers.js') }}" type="text/javascript"></script>
    <script src="{{ asset_with_version('frontend/assets/js/utils/router.js') }}" type="text/javascript"></script>
    <script src="{{ asset_with_version('backoffice/assets/vendors/general/toastr/build/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset_with_version('frontend/bundle/js/app.min.js') }}" type="text/javascript"></script>

    @yield('js_scipt')
</body>
</html>
