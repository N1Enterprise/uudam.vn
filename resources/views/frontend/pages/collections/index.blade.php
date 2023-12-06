@extends('frontend.layouts.master')

@section('page_title')
{{ data_get($collection, 'meta_title', $collection, 'name') }}
@endsection

@section('page_seo')
<meta name="description" content="{{ data_get($collection, 'meta_description') }}">
<meta name="keywords" content="{{ data_get($collection, 'name') }}">
<meta property="og:title" content="{{ data_get($collection, 'meta_title', $collection, 'name') }}">
<meta property="og:description" content="{{ data_get($collection, 'meta_description') }}">
<meta property="og:image" content="{{ data_get($collection, 'primary_image') }}">
<meta property="og:image:secure_url" content="{{ data_get($collection, 'product_image') }}">
<meta property="og:url" content="{{ route('fe.web.collections.index', data_get($collection, 'slug')) }}">
<meta property="og:site_name" content="{{ config('app.user_domain') }}) }}">
<meta property="og:type" content="website">
<meta property="og:locale" content="vi_VN">
<meta property="og:price:currency" content="VND">
<meta name="al:ios:app_name" content="{{ data_get($PAGE_SETTINGS, 'app_name') }}">
<meta name="al:iphone:app_name" content="{{ data_get($PAGE_SETTINGS, 'app_name') }}">
<meta name="al:ipad:app_name" content="{{ data_get($PAGE_SETTINGS, 'app_name') }}">
@endsection

@push('style_pages')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-collection-hero.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/template-collection.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-card.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-price.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-rte.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/custom.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-facets.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-loading-overlay.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/recommendation.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/vendors/owl-carousel/dist/assets/owl.carousel.css') }}">
<style>
@media screen and (max-width: 749px) {
    .collection-hero--with-image .collection-hero__inner {
        padding-bottom: calc(4px + 2rem);
    }
}
.ls-add-to-cart-wrap {
    font-size: 1rem;
    width: 80%;
    margin: auto;
    display: inline-block;
    position: relative;
}
.ls-add-to-cart-wrap {
    display: inline-block;
    font-size: 1rem;
    margin: auto;
    position: relative;
    width: 80%;
}
.ls-recommendation-box[data-host-page=Collection] .ls-add-to-cart-wrap {
    width: 100%;
}
.ls-button {
    position: relative;
    border: 1px solid #444;
    outline: none;
    border-radius: 3px;
    background-color: #212121;
    color: #fff;
    box-sizing: border-box;
    padding: 0.1em 0.5em;
    margin: 0;
    font-size: 1em;
    font-weight: 600;
    line-height: 2em;
    display: inline-block;
    width: 100%;
    background-image: none;
    cursor: pointer;
    text-decoration: none;
    text-align: center;
}
.ls-add-to-cart {
    -webkit-appearance: none;
    background: #fff;
    background-image: none;
    border: thin solid #444;
    border-radius: 3px;
    box-sizing: border-box;
    color: #000;
    cursor: pointer;
    display: inline-block;
    font-size: 1em;
    line-height: 2em;
    margin: 0;
    outline: none;
    padding: 0.1em 0.5em;
    width: 100%;
}
.ls-add-to-cart {
    border-radius: 0px;
    background-color: #ffffff;
    color: #121212;
    border-color: #121212;
    font-size: 15px;
    font-weight: 400;
    font-family: Assistant, sans-serif;
}
.ls-recommendation-box:not([data-host-page='OrderStatus']) .ls-add-to-cart {
    padding: 0.8rem;
    letter-spacing: 1px;
}
</style>
@endpush

@section('content_body')
<div class="shopify-section section">
    @include('frontend.pages.collections.partials.information')
</div>

<div class="shopify-section section">
    @if(! $linkedFeaturedInventories->isEmpty())
    @include('frontend.pages.collections.partials.most-popular')
    @endif

    @include('frontend.pages.collections.partials.product-items')
</div>
@endsection

@push('js_pages')
<script src="{{ asset('frontend/vendors/owl-carousel/dist/owl.carousel.js') }}" type="text/javascript"></script>
<script src="{{ asset('frontend/assets/js/components/owl-slider.js') }}"></script>

<script>
    $('[data-collection-mobile-filter-open]').on('click', function() {
        $('details.disclosure-has-popup').addClass('menu-opening');

        setTimeout(() => {
            $('[data-collection-mobile-filter-close]').on('click', function() {
                if ($('details.disclosure-has-popup').hasClass('menu-opening')) {
                    $('details.disclosure-has-popup').removeClass('menu-opening');
                }

                $('[data-collection-mobile-filter-close]').off('click');
            });
        }, 200);
    });

    $('#SortBy-mobile[data-collection-linked-inventory="sort_by"]').on('change', function() {
        $('.mobile-facets__close--no-js').trigger('click');
    });
</script>

@include('frontend.pages.collections.js-pages.collection-inventory')
@endpush
