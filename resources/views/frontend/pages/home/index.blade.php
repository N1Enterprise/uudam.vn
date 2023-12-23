@extends('frontend.layouts.master')

@section('page_title')
{{ data_get($PAGE_SETTINGS, 'app_name') }} | {{ config('app.user_domain') }}
@endsection

@section('page_seo')
<meta property="og:title" content="{{ data_get($PAGE_SETTINGS, 'app_name') }} | {{ config('app.user_domain') }}">
<meta property="og:description" content="{{ data_get($PAGE_SETTINGS, 'app_name') }} | {{ config('app.user_domain') }}">
<meta property="og:url" content="{{ request()->url() }}">
<meta property="og:site_name" content="{{ config('app.user_domain') }} }}">
<meta property="og:type" content="website">
<meta property="og:locale" content="vi_VN">
<meta property="og:price:currency" content="VND">
<meta name="al:ios:app_name" content="{{ data_get($PAGE_SETTINGS, 'app_name') }}">
<meta name="al:iphone:app_name" content="{{ data_get($PAGE_SETTINGS, 'app_name') }}">
<meta name="al:ipad:app_name" content="{{ data_get($PAGE_SETTINGS, 'app_name') }}">
@endsection

@push('style_pages')
<link rel="stylesheet" href="{{ asset_with_version('frontend/assets/css/common/component-slider-1.css') }}">
<link rel="stylesheet" href="{{ asset_with_version('frontend/assets/css/pages/home/index.css') }}">
<link rel="stylesheet" href="{{ asset_with_version('frontend/assets/css/common/section-featured-blog.css') }}">
<link rel="stylesheet" href="{{ asset_with_version('frontend/assets/css/common/component-card.css') }}">
<link rel="stylesheet" href="{{ asset_with_version('frontend/assets/css/common/component-article-card.css') }}">
<link rel="stylesheet" href="{{ asset_with_version('frontend/assets/css/common/section-multicolumn.css') }}">
<link rel="stylesheet" href="{{ asset_with_version('frontend/assets/css/common/recommendation.css') }}">
<link rel="stylesheet" href="{{ asset_with_version('frontend/assets/css/common/component-slideshow.css') }}">
<link rel="stylesheet" href="{{ asset_with_version('frontend/assets/css/common/component-slider.css') }}">
<link rel="stylesheet" href="{{ asset_with_version('frontend/assets/css/common/section-image-banner.css') }}">
<link rel="stylesheet" href="{{ asset_with_version('frontend/vendors/owl-carousel/dist/assets/owl.carousel.css') }}">
@endpush

@section('content_body')
<section class="shopify-section section">
    @include('frontend.pages.home.partials.section-banner')
</section>

@if (has_data($homePageDisplayOrders))
    @foreach ($homePageDisplayOrders as $homePageDisplayOrder)
    <section class="shopify-section section">
        <div class="section-template-padding page-width">
            <h3 class="ls-box-title">{{ data_get($homePageDisplayOrder, 'name') }}</h3>

            @if (has_data(data_get($homePageDisplayOrder, 'items', [])))
                @foreach (data_get($homePageDisplayOrder, 'items', []) as $item)
                <div data-section="home_page_display_{{ data_get($item, 'type') }}:{{ data_get($item, 'id') }}" data-section-defer="true">
                    <limespot-box data-owner="LimeSpot" class="ls-recommendation-box limespot-recommendation-box ls-animate no-zoom" data-box-style="carousel" style="display: block;">
                        <div class="recommendation-items" data-show="">
                            @if (data_get($item, 'type') == enum('HomePageDisplayType')::PRODUCT)
                            @include('frontend.pages.home.partials.recommendation-products')
                            @endif
    
                            @if (data_get($item, 'type') == enum('HomePageDisplayType')::COLLECTION)
                            @include('frontend.pages.home.partials.recommendation-collections')
                            @endif

                            @if (data_get($item, 'type') == enum('HomePageDisplayType')::POST)
                            @include('frontend.pages.home.partials.recommendation-posts')
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
    @include('frontend.pages.home.partials.section-featured-videos')
    @endif
</section>

@if(!empty($PAGE_HIGHLIGHT_INFORMATION))
<section class="shopify-section section">
    @include('frontend.pages.home.partials.section-our-highlights')
</section>
@endif
@endsection

@push('js_pages')
<script src="{{ asset_with_version('frontend/vendors/owl-carousel/dist/owl.carousel.js') }}" type="text/javascript"></script>
<script src="{{ asset_with_version('frontend/assets/js/components/owl-slider.js') }}"></script>
<script src="{{ asset_with_version('frontend/bundle/js/home/index.min.js') }}"></script>
@endpush
