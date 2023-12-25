@extends('frontend.layouts.master')

@section('page_title')
Giỏ hàng | {{ config('app.user_domain') }}
@endsection

@push('style_pages')
<link href="{{ asset_with_version('frontend/bundle/css/component-cart.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset_with_version('frontend/bundle/css/component-cart-drawer.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset_with_version('frontend/bundle/css/component-cart-items.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('page_seo')
<meta property="og:title" content="Giỏ hàng | {{ config('app.user_domain') }}">
<meta property="og:description" content="Giỏ hàng | {{ config('app.user_domain') }}">
<meta property="og:url" content="{{ request()->url() }}">
<meta property="og:site_name" content="{{ config('app.user_domain') }} }}">
<meta property="og:type" content="website">
<meta property="og:locale" content="vi_VN">
<meta property="og:price:currency" content="VND">
<meta name="al:ios:app_name" content="{{ data_get($SYSTEM_SETTING, 'page_settings.app_name') }}">
<meta name="al:iphone:app_name" content="{{ data_get($SYSTEM_SETTING, 'page_settings.app_name') }}">
<meta name="al:ipad:app_name" content="{{ data_get($SYSTEM_SETTING, 'page_settings.app_name') }}">
@endsection

@section('content_body')
<div class="shopify-section">
    @if(!empty($cart) && !$items->isEmpty())
    @include('frontend.pages.carts.partials.cart-items')
    @include('frontend.pages.carts.partials.cart-footer')
    @else
    @include('frontend.pages.carts.partials.cart-empty')
    @endif
</div>
@endsection

@section('js_script')
<script src="{{ asset_with_version('frontend/bundle/js/cart-index.min.js') }}" type="text/javascript"></script>
@endsection
