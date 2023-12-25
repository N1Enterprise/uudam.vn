@extends('frontend.layouts.master')

@section('page_title')
{{ data_get($inventory, 'meta_title', data_get($inventory, 'title')) }} | {{ config('app.user_domain') }}
@endsection

@section('page_seo')
<meta name="description" content="{{ data_get($inventory, 'meta_description') }}">
<meta name="keywords" content="{{ data_get($inventory, 'title') }}">
<meta property="og:title" content="{{ data_get($inventory, 'meta_title', data_get($inventory, 'title')) }}">
<meta property="og:description" content="{{ data_get($inventory, 'meta_description') }}">
<meta property="og:image" content="{{ data_get($inventory, 'product_image') }}">
<meta property="og:image:secure_url" content="{{ data_get($inventory, 'product_image') }}">
<meta property="og:url" content="{{ route('fe.web.products.index', data_get($inventory, 'slug')) }}">
<meta property="og:site_name" content="{{ config('app.user_domain') }}) }}">
<meta property="og:type" content="website">
<meta property="og:locale" content="vi_VN">
<meta property="og:price:amount" content="{{ round_money($inventory->sale_price) }}">
<meta property="og:price:currency" content="VND">
<meta name="al:ios:app_name" content="{{ data_get($SYSTEM_SETTING, 'page_settings.app_name') }}">
<meta name="al:iphone:app_name" content="{{ data_get($SYSTEM_SETTING, 'page_settings.app_name') }}">
<meta name="al:ipad:app_name" content="{{ data_get($SYSTEM_SETTING, 'page_settings.app_name') }}">
<meta name="brand" content="{{ data_get($inventory, 'product.branch') }}">
<meta name="product" content="{{ data_get($inventory, 'product.id') }}">
@endsection

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

    .product-description {
        line-height: 1;
        font-size: 1.5rem;
    }
</style>
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/product-index.min.css') }}">
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/component-slider-2.min.css') }}">
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/component-price.min.css') }}">
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/spr.min.css') }}">
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/recommendation.min.css') }}">
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/product-attribute.min.css') }}">
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/component-card.min.css') }}">
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/component-article-card.min.css') }}">
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/component-loading-overlay.min.css') }}">
<link rel="stylesheet" href="{{ asset_with_version('frontend/vendors/owl-carousel/dist/assets/owl.carousel.css') }}">
@endpush

@push('style_pages')
<style>
[data-owl-id="Slider_Product_Thumnail"] button.thumbnail {
    padding: 5px!important;
    border: none;
}

[data-owl-id="Slider_Product_Thumnail"] button.thumbnail[aria-current] img {
    border: 2px solid #000;
}
.confirm-buy-with-combo {
    background-color: #fff;
    border: 1px solid #000;
    padding: 4px 9px;
    cursor: pointer;
    font-weight: 800;
    font-size: 15px;
    display: flex;
    align-items: center;
    width: 173px;
    justify-content: space-between;
}
</style>
@endpush

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
        <div class="product__description rte quick-add-hidden" tagable>
            <div class="product-description">{!! data_get($inventory, 'product.description') !!}</div>
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

@section('js_script')
<script src="{{ asset_with_version('frontend/vendors/owl-carousel/dist/owl.carousel.js') }}" type="text/javascript"></script>
<script src="{{ asset_with_version('frontend/assets/js/components/owl-slider.js') }}" type="text/javascript"></script>
<script src="{{ asset_with_version('frontend/bundle/js/product-index.min.js') }}" type="text/javascript"></script>
@endsection
