<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title></title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-locale" content="{{ \App::currentLocale() }}">
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

    @yield('style_datatable')
    @yield('style')
    @stack('style_pages')
    <!--end::Layout Skins -->

    <!--begin::Page Vendors Styles -->
    <link href="{{ asset('frontend/assets/css/common/main.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('frontend/assets/css/common/reset.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('frontend/assets/css/common/base.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('frontend/assets/css/common/buddha-megamenu2.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('frontend/assets/css/common/component-mega-menu.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendors Styles -->
</head>

<body class="gradient swym-ready swym-buttons-loaded">
    @include('frontend.layouts.parials.master-header')
    <main id="MainContent" class="content-for-layout focus-none" role="main" tabindex="-1">
        @yield('content_body')
    </main>

    <script src="{{ asset('backoffice/js/vendors/jquery.min.js') }}" type="text/javascript"></script>
    @yield('js_script')
    @stack('js_pages')
</body>
</html>
