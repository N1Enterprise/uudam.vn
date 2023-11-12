@extends('frontend.layouts.master')

@push('style_pages')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/upsell.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-cart.css') }}">
@endpush

@section('content_body')
    <div class="shopify-section">
        @include('frontend.pages.carts.partials.cart-items')
        @include('frontend.pages.carts.partials.cart-footer')
    </div>
@endsection
