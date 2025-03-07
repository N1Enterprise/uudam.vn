<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Thanh toán - {{ data_get($SYSTEM_SETTING, 'page_settings.title') }}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-locale" content="{{ \App::currentLocale() }}">
    @foreach (data_get($SYSTEM_SETTING, 'shop_favicons', []) as $favicon)
    <link rel="icon" type="image/png" sizes="{{ data_get($favicon, 'sizes') }}" href="{{ data_get($favicon, 'image') }}">
    @endforeach
    @yield('page_seo')
    <link href="{{ asset_with_version('backoffice/assets/vendors/general/toastr/build/toastr.css') }}" rel="stylesheet" type="text/css" />
    @if (data_get($SYSTEM_SETTING, 'google_analytics_tag'))
    {!! data_get($SYSTEM_SETTING, 'google_analytics_tag') !!}
    @endif
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
