@extends('frontend.layouts.master')

@push('style_pages')
<link rel="stylesheet" href="{{ asset('backoffice/assets/vendors/general/slick/slick.css') }}">
<link rel="stylesheet" href="{{ asset('backoffice/assets/vendors/general/slick/slick-theme.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-slider-1.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/pages/home/index.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/section-featured-blog.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-card.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-article-card.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/section-multicolumn.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/recommendation.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-slideshow.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-slider.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/section-image-banner.css') }}">
@endpush

@section('content_body')
    <section class="shopify-section section">
        {{-- @include('frontend.pages.home.partials.section-banner') --}}
        @include('frontend.pages.home.partials.section-banner-2')
    </section>

    <section class="shopify-section section">
        <div class="multicolumn color-background-1 gradient background-primary no-heading">
            @include('frontend.pages.home.partials.section-most-popular-items')
            @include('frontend.pages.home.partials.section-catalog-collection')
        </div>
    </section>

    <section class="shopify-section section">
        @include('frontend.pages.home.partials.section-our-collection')
    </section>

    <section class="shopify-section section">
        {{-- @include('frontend.pages.home.partials.section-you-may-like') --}}
        @include('frontend.pages.home.partials.section-you-may-like-2')
    </section>

    <section class="shopify-section section">
        @include('frontend.pages.home.partials.section-featured-videos')
    </section>

    <section class="shopify-section section">
        @include('frontend.pages.home.partials.section-blogs')
    </section>

    <section class="shopify-section section">
        @include('frontend.pages.home.partials.section-our-highlights')
    </section>
@endsection

@push('js_pages')
<script src="{{ asset('backoffice/assets/vendors/general/slick/slick.min.js') }}" type="text/javascript"></script>
@endpush
