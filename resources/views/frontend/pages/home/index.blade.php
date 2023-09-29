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
@endpush

@section('content_body')
    <section class="shopify-section section">
        @include('frontend.pages.home.partials.section-banner')
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
<script>
    $(document).ready(function() {
        const SLICK_BANNER = {
            element: $('.home-banner__slick'),
            init: () => {
                SLICK_BANNER.element.slick({ autoplay: true });

                SLICK_BANNER.onPrev();
                SLICK_BANNER.onNext();
            },
            onPrev: () => {
                $('.home-banner__slick-control').find('.slider-button.slider-button--prev').on('click', function() {
                    SLICK_BANNER.element.find('.slick-prev.slick-arrow').trigger('click');
                });
            },
            onNext: () => {
                $('.home-banner__slick-control').find('.slider-button.slider-button--next').on('click', function() {
                    SLICK_BANNER.element.find('.slick-next.slick-arrow').trigger('click');
                });
            },
        };

        SLICK_BANNER.init();
    });
</script>
@endpush
