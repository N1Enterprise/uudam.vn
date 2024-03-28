@extends('frontend.layouts.master')

@section('page_title')
{{ data_get($SYSTEM_SETTING, 'page_settings.app_name') }} | {{ config('app.user_domain') }}
@endsection

@section('page_seo')
{!! generate_seo_html(['page_name' => data_get($SYSTEM_SETTING, 'page_settings.app_name')]) !!}
@endsection

@push('style_pages')
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/home-index.min.css') }}">
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/component-slider-1.min.css') }}">
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/section-featured-blog.min.css') }}">
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/component-card.min.css') }}">
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/component-article-card.min.css') }}">
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/section-multicolumn.min.css') }}">
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/recommendation.min.css') }}">
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/component-slideshow.min.css') }}">
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/component-slider.min.css') }}">
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/section-image-banner.min.css') }}">
<link rel="stylesheet" href="{{ asset_with_version('frontend/vendors/owl-carousel/dist/assets/owl.carousel.css') }}">
@endpush

@section('content_body')
@if (has_data($homeBanners))
<section class="shopify-section section">
    @include('frontend.pages.home.partials.section-banner')
</section>
@endif

@if (has_data($homePageDisplayOrders))
    @foreach ($homePageDisplayOrders as $homePageDisplayOrder)
    <section class="shopify-section section">
        <div class="section-template-padding page-width">
            <div class="section-content-template">
                @if (! boolean(data_get($homePageDisplayOrder, 'hidden_name')))
                <h3 class="ls-box-title custom-ls-box-title">{{ data_get($homePageDisplayOrder, 'name') }}</h3>
                @endif

                @if (has_data(data_get($homePageDisplayOrder, 'items', [])))
                    @foreach (data_get($homePageDisplayOrder, 'items', []) as $item)
                    <div data-section="home_page_display_{{ data_get($item, 'type') }}:{{ data_get($item, 'id') }}" data-section-defer="true" style="overflow: hidden;">
                        <limespot-box data-owner="LimeSpot" class="ls-recommendation-box limespot-recommendation-box ls-animate no-zoom multicolumn background-primary" data-box-style="carousel" style="display: block;">
                            <div class="recommendation-items">
                                @if (data_get($item, 'type') == enum('HomePageDisplayType')::PRODUCT)
                                @include('frontend.pages.home.partials.recommendation-products')
                                @endif

                                @if (data_get($item, 'type') == enum('HomePageDisplayType')::COLLECTION)
                                @include('frontend.pages.home.partials.recommendation-collections')
                                @endif

                                @if (data_get($item, 'type') == enum('HomePageDisplayType')::POST)
                                @include('frontend.pages.home.partials.recommendation-posts')
                                @endif

                                @if (data_get($item, 'type') == enum('HomePageDisplayType')::BLOG)
                                @include('frontend.pages.home.partials.recommendation-blogs')
                                @endif

                                @if (data_get($item, 'type') == enum('HomePageDisplayType')::IN_APP_BANNER_100_PERCENT)
                                @include('frontend.pages.home.partials.recommendation-in-app-banners-100')
                                @endif

                                @if (data_get($item, 'type') == enum('HomePageDisplayType')::IN_APP_BANNER_50_PERCENT)
                                @include('frontend.pages.home.partials.recommendation-in-app-banners-50')
                                @endif
                            </div>
                        </limespot-box>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    @endforeach
@endif

<section class="shopify-section section">
    @if(! empty($videoOutsideUI))
    @include('frontend.pages.home.partials.section-outstanding-advantages')
    @endif
</section>

@if (has_data($videoCategories))
<section class="shopify-section section">
    @include('frontend.pages.home.partials.section-featured-videos')
</section>
@endif

@endsection

@push('js_pages')
<script src="{{ asset_with_version('frontend/vendors/owl-carousel/dist/owl.carousel.js') }}" type="text/javascript"></script>
<script src="{{ asset_with_version('frontend/assets/js/components/owl-slider.js') }}" type="text/javascript"></script>
<script src="{{ asset_with_version('frontend/bundle/js/home-deferload.min.js') }}" type="text/javascript"></script>
<script src="{{ asset_with_version('frontend/bundle/js/home-index.min.js') }}" type="text/javascript"></script>
@endpush
