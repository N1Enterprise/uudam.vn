@extends('frontend.layouts.master')

@section('page_title')
Giỏ hàng | {{ config('app.user_domain') }}
@endsection

@push('style_pages')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/upsell.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-cart.css') }}">
@endpush

@section('page_seo')
<meta property="og:title" content="Giỏ hàng | {{ config('app.user_domain') }}">
<meta property="og:description" content="Giỏ hàng | {{ config('app.user_domain') }}">
<meta property="og:url" content="{{ request()->url() }}">
<meta property="og:site_name" content="{{ config('app.user_domain') }} }}">
<meta property="og:type" content="website">
<meta property="og:locale" content="vi_VN">
<meta property="og:price:currency" content="VND">
<meta name="al:ios:app_name" content="{{ data_get($PAGE_SETTINGS, 'app_name') }}">
<meta name="al:iphone:app_name" content="{{ data_get($PAGE_SETTINGS, 'app_name') }}">
<meta name="al:ipad:app_name" content="{{ data_get($PAGE_SETTINGS, 'app_name') }}">
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
@include('frontend.pages.carts.js-pages.my-cart')
@endsection
