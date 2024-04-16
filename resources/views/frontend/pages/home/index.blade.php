@extends('frontend.layouts.master')

@section('page_title')
{{ data_get($SYSTEM_SETTING, 'page_settings.app_name') }} | {{ config('app.user_domain') }}
@endsection

@section('page_seo')
{!! generate_seo_html(['page_name' => data_get($SYSTEM_SETTING, 'page_settings.app_name')]) !!}
@endsection

@push('style_pages')
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/pages/home.min.css') }}">
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
                @php
                    $__frontend_custom        = data_get($homePageDisplayOrder, 'params.__frontend_custom', '');
                    $__header_image           = data_get($homePageDisplayOrder, 'params.__frontend_custom.header_image', '');
                    $__frontend_custom_enable = data_get($homePageDisplayOrder, 'params.__frontend_custom.enable', false);
                @endphp

                <div style="background: {{ boolean($__frontend_custom_enable) ? data_get($__frontend_custom, 'background', '#FFFFFF') : '' }}; border-radius: 3px;" {{ $__frontend_custom_enable ? 'has-frontend-custom' : '' }}>
                    @if (! boolean(data_get($homePageDisplayOrder, 'hidden_name')))
                    <div class="ls-box-title custom-ls-box-title">{{ data_get($homePageDisplayOrder, 'name') }}</div>
                    @elseif ($__frontend_custom_enable && $__header_image)
                    <div class="__frontend_custom_header_image">
                        <img src="{{ $__header_image }}" alt="{{ data_get($homePageDisplayOrder, 'name') }}" style="width: 100%; height: 100%;">
                    </div>
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
        </div>
    </section>
    @endforeach
@endif

@if (data_get($SYSTEM_SETTING, 'most_searched.enable'))
<section class="shopify-section section">
    <div class="section-template-padding page-width">
        <div class="section-content-template">
            <div class="ls-box-title custom-ls-box-title">Tìm kiếm nhiều</div>
            <div class="recommendation-target" style="overflow: hidden;">
                <div class="list-most-search">
                    @foreach (data_get($SYSTEM_SETTING, 'most_searched.links') as $link)
                    <a href="{{ data_get($link, 'link') }}" class="list-most-search-link" target="_blank">{{ data_get($link, 'name') }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
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
<script src="{{ asset_with_version('frontend/vendors/owl-carousel/dist/owl.carousel.min.js') }}" type="text/javascript"></script>
<script src="{{ asset_with_version('frontend/assets/js/components/owl-slider.js') }}" type="text/javascript"></script>
<script src="{{ asset_with_version('frontend/bundle/js/home-deferload.min.js') }}" type="text/javascript"></script>
<script src="{{ asset_with_version('frontend/bundle/js/home-index.min.js') }}" type="text/javascript"></script>
@endpush
