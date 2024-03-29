@extends('frontend.layouts.master')

@section('page_title')
{{ data_get($collection, 'name') }} | {{ config('app.user_domain') }}
@endsection

@section('page_seo')
{!! $collection->toHtmlSEO() !!}
@endsection

@push('style_pages')
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/pages/collection.min.css') }}">
@endpush

@section('content_body')
<input type="hidden" id="collection_resource" data-id="{{ $collection->id }}">
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
<script src="{{ asset_with_version('frontend/vendors/owl-carousel/dist/owl.carousel.js') }}" type="text/javascript"></script>
<script src="{{ asset_with_version('frontend/assets/js/components/owl-slider.js') }}"></script>
<script src="{{ asset_with_version('frontend/bundle/js/collection-index.min.js') }}"></script>

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
