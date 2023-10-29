@extends('frontend.layouts.master')

@push('style_pages')
<style>
    .section-template__main-padding {
        padding-top: 27px;
        padding-bottom: 9px;
    }

    @media screen and (min-width: 750px) {
        .section-template__main-padding {
            padding-top: 36px;
            padding-bottom: 12px;
        }
    }
</style>
<link rel="stylesheet" href="{{ asset('frontend/assets/css/pages/products/index.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-slider-2.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-price.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/spr.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/recommendation.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/product-attribute.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-card.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-article-card.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/vendors/owl-carousel/dist/assets/owl.carousel.css') }}">
@endpush

@section('page_title')
{{ $inventory->title }}
@endsection

@section('page_seo')
<meta name="description" content="{{ $inventory->meta_description }}">
<meta property="og:url" content="{{ route('fe.web.products.index', $inventory->slug) }}">
<meta property="og:title" content="{{ $inventory->meta_title }}">
<meta property="og:type" content="product">
<meta property="og:description" content="{{ $inventory->meta_description }}">
<meta property="og:image" content="{{ $inventory->product_image }}">
<meta property="og:image:secure_url" content="{{ $inventory->product_image }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="1200">
<meta property="og:price:amount" content="{{ round_money($inventory->sale_price) }}">
<meta property="og:price:currency" content="VND">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $inventory->meta_title }}">
<meta name="twitter:description" content="{{ $inventory->meta_description }}">
@endsection

@section('content_body')
<section class="shopify-section section">
    <section class="page-width section-template__main-padding">
        <div class="product product--large product--thumbnail_slider grid grid--1-col grid--2-col-tablet">
            <div class="media-gallery grid__item product__media-wrapper">
                <div class="product__media-gallery" aria-label="Gallery Viewer">
                    <div class="visually-hidden"></div>
                    @if(! empty($imageGalleries))
                    @include('frontend.pages.products.partials.gallery-viewer')
                    @include('frontend.pages.products.partials.gallery-thumbnails')
                    @endif
                </div>
            </div>
            <div class="product__info-wrapper grid__item">
                @include('frontend.pages.products.partials.product-info')
            </div>
        </div>
    </section>
</section>

<section class="shopify-section section">
    <div class="multicolumn color-background-1 gradient background-primary no-heading">
        <div class="page-width section-template-padding isolate">
            <div class="slider-component slider-mobile-gutter">
                <ul class="multicolumn-list contains-content-container grid grid--1-col-tablet-down grid--1-col-desktop" role="list">
                    <li class="multicolumn-list__item grid__item multicolumn-list__item--empty">
                        <div class="multicolumn-card content-container">
                            <div class="multicolumn-card__info"></div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="center"></div>
        </div>
    </div>
</section>

<section class="shopify-section section review-section">
    <div class="page-width">
        <div class="product__description rte quick-add-hidden">
            <div class="editorjs-content product-description"></div>
        </div>
    </div>
</section>

<section class="shopify-section section review-section">
    @include('frontend.pages.products.partials.product-review')
</section>

@if(! empty($suggestedInventories))
<limespot>
    <limespot-container>
        @include('frontend.pages.products.partials.suggested-products')
    </limespot-container>
</limespot>
@endif

@if(! empty($suggestedPosts))
<section class="shopify-section section">
    @include('frontend.pages.products.partials.suggested-posts')
</section>
@endif

@include('frontend.pages.products.partials.gallery-image-modal')
@endsection

@push('js_pages')
@include('frontend.pages.products.js-pages.index')
<script src="{{ asset('frontend/vendors/owl-carousel/dist/owl.carousel.js') }}" type="text/javascript"></script>
<script src="{{ asset('frontend/assets/js/components/owl-slider.js') }}"></script>
@endpush
