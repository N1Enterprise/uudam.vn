@extends('frontend.layouts.master')

@section('page_title')
Tìm kiếm | {{ config('app.user_domain') }}
@endsection

@section('page_seo')
{!! generate_static_page_seo_html('search'. [':query' => $query]) !!}
@endsection

@push('style_pages')
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/pages/search.min.css') }}">
@endpush

@section('content_body')
<div class="shopify-section section">
    <div class="page-width" style="padding-top: 20px; padding-bottom: 20px;">
        kết quả tìm kiếm: <span style="margin-left: 2px; display: inline-block;" data-search-query>{{ $query }}</span>
    </div>
</div>

<div class="shopify-section section">
    @include('frontend.pages.search.partials.product-items')
</div>
@endsection

@push('js_pages')
<script src="{{ asset_with_version('frontend/vendors/owl-carousel/dist/owl.carousel.min.js') }}" type="text/javascript"></script>
<script src="{{ asset_with_version('frontend/assets/js/components/owl-slider.js') }}"></script>
<script src="{{ asset_with_version('frontend/bundle/js/component-search.min.js') }}"></script>

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
@endpush
