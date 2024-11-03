@extends('frontend.layouts.master')

@section('page_title')
{{ get_static_page_seo_title('cart') }}
@endsection

@push('style_pages')
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/pages/cart.min.css') }}">
@endpush

@section('page_seo')
{!! generate_static_page_seo_html('cart') !!}
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
