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
                    $__frontend_custom          = data_get($homePageDisplayOrder, 'params.__frontend_custom', '');
                    $__frontend_header_image    = data_get($homePageDisplayOrder, 'params.__frontend_custom.header_image', '');
                    $__frontend_title_color     = data_get($homePageDisplayOrder, 'params.__frontend_custom.title_color', '#000000');
                    $__frontend_custom_enable   = data_get($homePageDisplayOrder, 'params.__frontend_custom.enable', false);
                    $__frontend_background      = data_get($homePageDisplayOrder, 'params.__frontend_custom.background', '#FFFFFF');

                    $__flash_sale_enable        = data_get($homePageDisplayOrder, 'params.flash_sale.enable', false);
                    $__flash_sale_start_at      = data_get($homePageDisplayOrder, 'params.flash_sale.start_at', false);
                    $__flash_sale_end_at        = data_get($homePageDisplayOrder, 'params.flash_sale.end_at', false);

                    $__flash_sale_color_bg      = data_get($homePageDisplayOrder, 'params.flash_sale.colors.bg', 'transparent');
                    $__flash_sale_color_timebg  = data_get($homePageDisplayOrder, 'params.flash_sale.colors.time_bg', '#000');
                    $__flash_sale_color_timetxt = data_get($homePageDisplayOrder, 'params.flash_sale.colors.time_text', '#000');
                    $__flash_sale_color_text    = data_get($homePageDisplayOrder, 'params.flash_sale.colors.text', '#FFF');

                    $__more_link                = data_get($homePageDisplayOrder, 'params.more_link');
                @endphp

                <div style="background: {{ boolean($__frontend_custom_enable) ? $__frontend_background : '' }}; border-radius: 3px;" {{ $__frontend_custom_enable ? 'has-frontend-custom' : '' }}>
                    <div class="homepage-viewer-header">
                        <div class="homepage-viewer-title">
                            @if (! boolean(data_get($homePageDisplayOrder, 'hidden_name')))
                            <div class="ls-box-title custom-ls-box-title" style="color: {{ boolean($__frontend_custom_enable) ? $__frontend_title_color : '' }}">{{ data_get($homePageDisplayOrder, 'name') }}</div>
                            @elseif ($__frontend_custom_enable && $__frontend_header_image)
                            <div class="__frontend_custom_header_image">
                                <img src="{{ $__frontend_header_image }}" alt="{{ data_get($homePageDisplayOrder, 'name') }}" style="width: 100%; height: 100%;">
                            </div>
                            @endif
                        </div>
                        @if ($__flash_sale_enable)
                        <div class="homepage-viewer-flash-sale details-pro">
                            <div class="flashsale" style="--countdown-background: #000000; --countdown-color: #ffffff; --process-background: #ffaaaf; --process-color1: #ff424e; --process-color2: #ff424e; --stock-color: #000000; background: transparent; --heading-color: #000000;">
                                <div class="flashsale__header" style="background: {{ $__flash_sale_color_bg }};">
                                    <div class="flashsale__countdown-wrapper">
                                        <span class="flashsale__countdown-label mr-2 d-none" style="display: inline;">Kết thúc sau</span>
                                        <div class="flashsale__countdown" data-flash-sale-id="product_detail" data-flash-sale-start-at="{{ $__flash_sale_start_at }}" data-flash-sale-end-at="{{ $__flash_sale_end_at }}" data-isongoing-flash-sale="true">
                                            <div class="ega-badge-ctd">
                                                <div style="background: {{ $__flash_sale_color_timebg }};">
                                                    <div style="color: {{ $__flash_sale_color_timetxt }};" class="ega-badge-ctd__item" data-flash-sale-days-id="product_detail">00</div>
                                                    <span class="hidden">Ngày</span>
                                                </div>
                                                <div class="ega-badge-ctd__colon" style="color: {{ $__flash_sale_color_text }};">Ngày</div>
                                                <div style="background: {{ $__flash_sale_color_timebg }};">
                                                    <div style="color: {{ $__flash_sale_color_timetxt }};" class="ega-badge-ctd__item" data-flash-sale-hours-id="product_detail">00</div>
                                                    <span class="hidden">Giờ</span>
                                                </div>
                                                <div class="ega-badge-ctd__colon" style="color: {{ $__flash_sale_color_text }};">Giờ</div>
                                                <div style="background: {{ $__flash_sale_color_timebg }};">
                                                    <div style="color: {{ $__flash_sale_color_timetxt }};" class="ega-badge-ctd__item" data-flash-sale-minutes-id="product_detail">00</div>
                                                    <span class="hidden">Phút</span>
                                                </div>
                                                <div class="ega-badge-ctd__colon" style="color: {{ $__flash_sale_color_text }};">Phút</div>
                                                <div style="background: {{ $__flash_sale_color_timebg }};">
                                                    <div style="color: {{ $__flash_sale_color_timetxt }};" class="ega-badge-ctd__item" data-flash-sale-seconds-id="product_detail">00</div>
                                                    <span class="hidden">Giây</span>
                                                </div>
                                                <div class="ega-badge-ctd__colon" style="color: {{ $__flash_sale_color_text }};">Giây</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if (has_data($__more_link))
                        <a href="{{ data_get($__more_link, 'cta_link') }}" class="home-more-link">{{ data_get($__more_link, 'cta_label') }}</a>
                        @endif
                    </div>

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
<script src="{{ asset_with_version('frontend/bundle/js/flash-sale.min.js') }}" type="text/javascript"></script>
@endpush
