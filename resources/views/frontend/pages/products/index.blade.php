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
<link rel="stylesheet" href="{{ asset('backoffice/assets/vendors/general/slick/slick.css') }}">
<link rel="stylesheet" href="{{ asset('backoffice/assets/vendors/general/slick/slick-theme.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/pages/products/index.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-slider-2.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-price.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/spr.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/recommendation.css') }}">
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
                <ul class="multicolumn-list contains-content-container grid grid--1-col-tablet-down grid--1-col-desktop" id="Slider-template--16599720820986__1658169167404dabb0" role="list">
                    <li id="Slide-template--16599720820986__1658169167404dabb0-1" class="multicolumn-list__item grid__item multicolumn-list__item--empty">
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

<section class="shopify-section section">
    @include('frontend.pages.products.partials.product-review')
</section>

<limespot>
    <limespot-container>
        @include('frontend.pages.products.partials.related-items')
    </limespot-container>
</limespot>
@endsection

@push('js_pages')
<script src="{{ asset('backoffice/assets/vendors/general/slick/slick.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('backoffice/assets/vendors/general/editorjs-parser/build/Parser.browser.js') }}" type="text/javascript"></script>
<script src="{{ asset('frontend/assets/js/components/editorjs-parser.js') }}" type="text/javascript"></script>
<script>
    $('.share-button__copy').on('click', function() {
        const text = $('#url.field__input').val();

        __HELPER__.copyClipBoard(text);
    });
</script>
@endpush
