@extends('frontend.layouts.master')

@push('style_pages')
<link rel="stylesheet" href="{{ asset('backoffice/assets/vendors/general/slick/slick.css') }}">
<link rel="stylesheet" href="{{ asset('backoffice/assets/vendors/general/slick/slick-theme.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-collection-hero.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/template-collection.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-card.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-price.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-rte.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/custom.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-facets.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-loading-overlay.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/recommendation.css') }}">
<style>
    @media screen and (max-width: 749px) {
        .collection-hero--with-image .collection-hero__inner {
        padding-bottom: calc(4px + 2rem);
        }
    }

    .ls-add-to-cart-wrap {
    font-size: 1rem;
    width: 80%;
    margin: auto;
    display: inline-block;
    position: relative;
}

    .ls-add-to-cart-wrap {
    display: inline-block;
    font-size: 1rem;
    margin: auto;
    position: relative;
    width: 80%;
}

    .ls-recommendation-box[data-host-page=Collection] .ls-add-to-cart-wrap {
    width: 100%;
}

.ls-button {
    position: relative;
    border: 1px solid #444;
    outline: none;
    border-radius: 3px;
    background-color: #212121;
    color: #fff;
    box-sizing: border-box;
    padding: 0.1em 0.5em;
    margin: 0;
    font-size: 1em;
    font-weight: 600;
    line-height: 2em;
    display: inline-block;
    width: 100%;
    background-image: none;
    cursor: pointer;
    text-decoration: none;
    text-align: center;
}

.ls-add-to-cart {
    -webkit-appearance: none;
    background: #fff;
    background-image: none;
    border: thin solid #444;
    border-radius: 3px;
    box-sizing: border-box;
    color: #000;
    cursor: pointer;
    display: inline-block;
    font-size: 1em;
    line-height: 2em;
    margin: 0;
    outline: none;
    padding: 0.1em 0.5em;
    width: 100%;
}

.ls-add-to-cart {
    border-radius: 0px;
    background-color: #ffffff;
    color: #121212;
    border-color: #121212;
    font-size: 15px;
    font-weight: 400;
    font-family: Assistant, sans-serif;
}

.ls-recommendation-box:not([data-host-page='OrderStatus']) .ls-add-to-cart {
    padding: 0.8rem;
    letter-spacing: 1px;
}
</style>
@endpush

@section('content_body')
<div class="shopify-section section">
    @include('frontend.pages.collections.partials.information')
</div>

<div class="shopify-section section">
    @include('frontend.pages.collections.partials.most-popular')
    @include('frontend.pages.collections.partials.product-items')
</div>
@endsection

@push('js_pages')
<script src="{{ asset('backoffice/assets/vendors/general/slick/slick.min.js') }}" type="text/javascript"></script>
@endpush
