@extends('frontend.layouts.master')

@push('style_pages')
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
<link rel="stylesheet" href="{{ asset('frontend/vendors/owl-carousel/dist/assets/owl.carousel.css') }}">
@endpush

@section('content_body')
    <section class="shopify-section section">
        @include('frontend.pages.home.partials.section-banner')
    </section>

    <section class="shopify-section section">
        <div class="multicolumn color-background-1 gradient background-primary no-heading">
            @if(! $popularInventories->isEmpty())
            @include('frontend.pages.home.partials.section-most-popular-items')
            @endif

            @if(! $featuredCollections->isEmpty())
            @include('frontend.pages.home.partials.section-catalog-collection')
            @endif
        </div>
    </section>

    <section class="shopify-section section">
        @if(! $displayOnFrontendCollections->isEmpty())
        @include('frontend.pages.home.partials.section-our-collection')
        @endif
    </section>

    <section class="shopify-section section">
        @include('frontend.pages.home.partials.section-you-may-like')
    </section>

    <section class="shopify-section section">
        @if(! empty($videoOutsideUI))
        @include('frontend.pages.home.partials.section-featured-videos')
        @endif
    </section>

    <section class="shopify-section section">
        @if(! $postCategories->isEmpty())
        @include('frontend.pages.home.partials.section-blogs')
        @endif
    </section>

    @if(!empty($PAGE_HIGHLIGHT_INFORMATION))
    <section class="shopify-section section">
        @include('frontend.pages.home.partials.section-our-highlights')
    </section>
    @endif
@endsection

@push('js_pages')
<script src="{{ asset('frontend/vendors/owl-carousel/dist/owl.carousel.js') }}" type="text/javascript"></script>
<script src="{{ asset('frontend/assets/js/components/owl-slider.js') }}"></script>
@endpush
