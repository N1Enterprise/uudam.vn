@extends('frontend.layouts.checkout')

@section('page_title')
Thanh toán | {{ config('app.user_domain') }}
@endsection

@section('page_seo')
<meta property="og:title" content="Thanh toán | {{ config('app.user_domain') }}">
<meta property="og:description" content="Thanh toán | {{ config('app.user_domain') }}">
<meta property="og:url" content="{{ request()->url() }}">
<meta property="og:site_name" content="{{ config('app.user_domain') }} }}">
<meta property="og:type" content="website">
<meta property="og:locale" content="vi_VN">
<meta property="og:price:currency" content="VND">
<meta name="al:ios:app_name" content="{{ data_get($SYSTEM_SETTING, 'page_settings.app_name') }}">
<meta name="al:iphone:app_name" content="{{ data_get($SYSTEM_SETTING, 'page_settings.app_name') }}">
<meta name="al:ipad:app_name" content="{{ data_get($SYSTEM_SETTING, 'page_settings.app_name') }}">
@endsection

@section('style')
<link href="{{ asset('vendor/validate/styles.css') }}" rel="stylesheet" type="text/css" />
<style>
    input:disabled,
    select:disabled {
        background: #f9f9f9;
    }
</style>
@endsection

@section('content_body')
@include('frontend.pages.checkouts.partials.payment')
@include('frontend.pages.checkouts.partials.items')
@endsection

@section('js_scipt')
<script src="{{ asset_with_version('frontend/assets/js/common/main.js') }}" type="text/javascript"></script>
<script src="{{ asset_with_version('frontend/assets/js/utils/helpers.js') }}" type="text/javascript"></script>
<script src="{{ asset_with_version('vendor/validate/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset_with_version('vendor/validate/custom.js') }}" type="text/javascript"></script>
<script src="{{ asset_with_version('frontend/bundle/js/checkout-index.min.js') }}" type="text/javascript"></script>
@endsection
