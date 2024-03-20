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
{!! generate_seo_html(['page_name' => 'Giỏ hàng']) !!}
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
