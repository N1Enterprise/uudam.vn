@extends('frontend.layouts.master')

@push('style_pages')
<style>
    .section-template__main-padding {
        padding-top: 27px;
        padding-bottom: 9px;
    }

    @media screen and (min-width: 750px) {
        .section-template__main-padding {
            padding-top: 36px;
            padding-bottom: 12px;
        }
    }
</style>
<link rel="stylesheet" href="{{ asset('backoffice/assets/vendors/general/slick/slick.css') }}">
<link rel="stylesheet" href="{{ asset('backoffice/assets/vendors/general/slick/slick-theme.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/pages/products/index.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-slider-2.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-price.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/spr.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/recommendation.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/product-attribute.css') }}">
@endpush

@section('content_body')
<section class="shopify-section section">
    <section class="page-width section-template__main-padding">
        <div class="product product--large product--thumbnail_slider grid grid--1-col grid--2-col-tablet">
            <div class="media-gallery grid__item product__media-wrapper">
                <div class="product__media-gallery" aria-label="Gallery Viewer">
                    <div class="visually-hidden"></div>
                    @if(! empty($imageGalleries))
                    @include('frontend.pages.products.partials.gallery-viewer')
                    @include('frontend.pages.products.partials.gallery-thumbnails')
                    @endif
                </div>
            </div>
            <div class="product__info-wrapper grid__item">
                @include('frontend.pages.products.partials.product-info')
            </div>
        </div>
    </section>
</section>

<section class="shopify-section section">
    <div class="multicolumn color-background-1 gradient background-primary no-heading">
        <div class="page-width section-template-padding isolate">
            <div class="slider-component slider-mobile-gutter">
                <ul class="multicolumn-list contains-content-container grid grid--1-col-tablet-down grid--1-col-desktop" id="Slider-template--16599720820986__1658169167404dabb0" role="list">
                    <li id="Slide-template--16599720820986__1658169167404dabb0-1" class="multicolumn-list__item grid__item multicolumn-list__item--empty">
                        <div class="multicolumn-card content-container">
                            <div class="multicolumn-card__info"></div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="center"></div>
        </div>
    </div>
</section>

<section class="shopify-section section">
    @include('frontend.pages.products.partials.product-review')
</section>

<limespot>
    <limespot-container>
        @include('frontend.pages.products.partials.related-items')
    </limespot-container>
</limespot>
@endsection

@push('js_pages')
<script src="{{ asset('backoffice/assets/vendors/general/slick/slick.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('backoffice/assets/vendors/general/editorjs-parser/build/Parser.browser.js') }}" type="text/javascript"></script>
<script src="{{ asset('frontend/assets/js/components/editorjs-parser.js') }}" type="text/javascript"></script>
<script>
    $('.share-button__copy').on('click', function() {
        const text = $('#url.field__input').val();

        __HELPER__.copyClipBoard(text);
    });

    const PRODUCT_VARIANTS = {
        init: () => {
            PRODUCT_VARIANTS.onChange();
        },
        variant_resources: (() => {
            const data = $('#inventory_variants').attr('data-variants') || '{}';

            return JSON.parse(data);
        })(),
        onChange: () => {
            $('[name="attribute_value"]').on('change', function() {
                const value = $(this).val();
                const parent = $(this).parents('.attributes-item');

                parent.find('[name="attribute_value"]').prop('checked', false);
                parent.find('[name="attribute_value"]').parents('.label').removeClass('active');

                $(this).prop('checked', true);
                $(this).parents('.label').addClass('active');

                const product = PRODUCT_VARIANTS.findProductByAttribute();
            });
        },
        findProductByAttribute: () => {
            const conditions = {};

            $.each($('.label.active'), function(index, element) {
                conditions[ + ($(element).find('input').attr('data-attribute-id')) ] = + ($(element).find('input').val());
            });

            const product = PRODUCT_VARIANTS.variant_resources.find(function(item) {
                const attributes = item.attributes.map((item) => item.id);
                const attrValues = item.attribute_values.map((item) => item.id);

                const matches = (() => {
                    if (
                        Object.keys(conditions).length == attributes.length
                        && Object.keys(conditions).every((id) => attributes.includes(+id))
                    ) {
                        if (
                            Object.values(conditions).length == attrValues.length
                            && Object.values(conditions).every((id) => attrValues.includes(+id))
                        ) {
                            return true;
                        }
                    }

                    return false;
                })();

                return matches;
            });

            if (product) {
                PRODUCT_VARIANTS.previewProduct(product);
            }
        },
        previewProduct: (product) => {
            const { title, sku, sale_price } = product;

            $('[data-title]').text(title);
            $('[data-sku]').text(sku);
            $('[data-sale-price]').text(sale_price);
        },
    };

    PRODUCT_VARIANTS.init();
</script>
@endpush
