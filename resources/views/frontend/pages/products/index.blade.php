@extends('frontend.layouts.master')

@section('page_title')
{{ data_get($inventory, 'title') }} | {{ config('app.user_domain') }}
@endsection

@section('page_seo')
{!! $inventory->toHtmlSEO() !!}
@endsection

@push('style_pages')
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/pages/product.min.css') }}">
@endpush

@section('content_body')
<section class="shopify-section section" style="margin-top: 10px;">
    <section class="page-width section-template__main-padding">
        <div class="product product--large product--thumbnail_slider grid grid--1-col grid--2-col-tablet">
            <div class="media-gallery grid__item product__media-wrapper">
                <div class="product__media-gallery">
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
                <ul class="multicolumn-list contains-content-container grid grid--1-col-tablet-down grid--1-col-desktop">
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

@if (has_data(data_get($inventory, 'product.description')))
<section class="shopify-section section review-section">
    <div class="page-width">
        <div class="rte quick-add-hidden" tagable>
            <div class="spr-container">
                <div class="spr-header">
                    <h2 class="spr-header-title" style="text-align: left;">Mô tả sản phẩm</h2>
                </div>
                <div class="spr-content product-description-content">
                    {!! data_get($inventory, 'product.description') !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<section class="shopify-section section review-section">
    @include('frontend.pages.products.partials.product-review')
</section>

{{-- @if(has_data($suggestedInventories))
<limespot>
    <limespot-container>
        @include('frontend.pages.products.partials.suggested-products')
    </limespot-container>
</limespot>
@endif --}}

{{-- @if(has_data($suggestedPosts))
<section class="shopify-section section">
    @include('frontend.pages.products.partials.suggested-posts')
</section>
@endif --}}

@include('frontend.pages.products.partials.gallery-image-modal')
@endsection

@section('js_script')
<script src="{{ asset_with_version('frontend/vendors/owl-carousel/dist/owl.carousel.min.js') }}" type="text/javascript"></script>
<script src="{{ asset_with_version('frontend/assets/js/components/owl-slider.js') }}" type="text/javascript"></script>
<script src="{{ asset_with_version('frontend/bundle/js/product-index.min.js') }}" type="text/javascript"></script>
@endsection
