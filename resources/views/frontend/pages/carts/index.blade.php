@extends('frontend.layouts.master')

@push('style_pages')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/upsell.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-cart.css') }}">
@endpush

@section('content_body')
<div class="shopify-section">
    @if(!$items->isEmpty())
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
