@extends('frontend.layouts.master')

@section('page_title')
{{ data_get($SYSTEM_SETTING, 'page_settings.app_name') }} | {{ config('app.user_domain') }}
@endsection

@section('page_seo')
<meta property="og:title" content="{{ data_get($SYSTEM_SETTING, 'page_settings.app_name') }} | {{ config('app.user_domain') }}">
<meta property="og:description" content="{{ data_get($SYSTEM_SETTING, 'page_settings.app_name') }} | {{ config('app.user_domain') }}">
<meta property="og:url" content="{{ request()->url() }}">
<meta property="og:site_name" content="{{ config('app.user_domain') }} }}">
<meta property="og:type" content="website">
<meta property="og:locale" content="vi_VN">
<meta property="og:price:currency" content="VND">
<meta name="al:ios:app_name" content="{{ data_get($SYSTEM_SETTING, 'page_settings.app_name') }}">
<meta name="al:iphone:app_name" content="{{ data_get($SYSTEM_SETTING, 'page_settings.app_name') }}">
<meta name="al:ipad:app_name" content="{{ data_get($SYSTEM_SETTING, 'page_settings.app_name') }}">
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
            <h3 class="ls-box-title custom-ls-box-title">{{ data_get($homePageDisplayOrder, 'name') }}</h3>

            @if (has_data(data_get($homePageDisplayOrder, 'items', [])))
                @foreach (data_get($homePageDisplayOrder, 'items', []) as $item)
                <div data-section="home_page_display_{{ data_get($item, 'type') }}:{{ data_get($item, 'id') }}" data-section-defer="true">
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
                        </div>
                    </limespot-box>
                </div>
                @endforeach
            @endif
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
