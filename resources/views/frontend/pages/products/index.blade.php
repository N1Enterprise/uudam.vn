@extends('frontend.layouts.master')

@section('page_title')
{{ data_get($inventory, 'title') }} | {{ config('app.user_domain') }}
@endsection

@section('page_seo')
{!! $inventory->toHtmlSEO() !!}
@endsection

@push('style_pages')
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/pages/product.min.css') }}">
@endpush

@section('content_body')
<section class="shopify-section section" style="margin-top: 10px;">
    <section class="page-width section-template__main-padding">
        <div class="product product--large product--info">
            <div class="product__title">
                <div class="product__title-wrapper">
                    <h1 data-title>{{ $inventory->title }}</h1>
                    <span class="data-sku-wrapper">
                        SKU: <span data-sku>{{ $inventory->sku }}</span>
                        @if (($inventory->final_sold_count))
                        <span class="sold_count sold_count_mobile">
                            <span style="padding: 0 10px;">|</span>
                            Đã bán {{ $inventory->final_sold_count }}
                        </span>
                        @endif
                    </span>
                </div>
            </div>
        </div>
        <div class="product product--large product--thumbnail_slider grid grid--1-col grid--2-col-tablet">
            <div class="media-gallery grid__item product__media-wrapper">
                <div class="product__media-gallery">
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
                <ul class="multicolumn-list contains-content-container grid grid--1-col-tablet-down grid--1-col-desktop">
                    <li class="multicolumn-list__item grid__item multicolumn-list__item--empty">
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

<section class="shopify-section section review-section">
    <div class="page-width">
       <div class="product-bottom-section">
            @if (has_data(data_get($inventory, 'product.description')))
            <div class="product-review-section">
                <div class="rte quick-add-hidden" tagable>
                    <div class="spr-container">
                        <div class="spr-header">
                            <h2 class="spr-header-title" style="text-align: left; text-transform: uppercase; font-weight: bold; color: #025B50; font-size: 17px;">Mô tả sản phẩm</h2>
                        </div>
                        <div class="spr-content product-description-content article__content">
                            {!! data_get($inventory, 'product.description') !!}
                        </div>
                        <div class="bg-article"></div>
                        <button type="button" id="see-product-description" class="act-button btn jsArticle" data-description-modal-open>
                            <span>Xem chi tiết mô tả sản phẩm</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="10" height="10" class="icon-view-more">
                                <path d="M224 416c-8.188 0-16.38-3.125-22.62-9.375l-192-192c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L224 338.8l169.4-169.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-192 192C240.4 412.9 232.2 416 224 416z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            @endif

            <div class="product-review-posts">
                <div class="rte">
                    <div class="spr-container">
                        <div class="spr-header">
                            <h2 class="spr-header-title" style="text-align: left; text-transform: uppercase; font-weight: bold; color: #025B50; font-size: 17px; display: flex; align-items: center;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="15" viewBox="0 0 20 15" style="margin-right: 5px; transform: translateY(-1px);">
                                    <path id="newspaper" d="M17.5,6.5V4H0V17.75A1.25,1.25,0,0,0,1.25,19H18.125A1.875,1.875,0,0,0,20,17.125V6.5ZM16.25,17.75h-15V5.25h15ZM2.5,7.75H15V9H2.5Zm7.5,2.5h5V11.5H10Zm0,2.5h5V14H10Zm0,2.5h3.75V16.5H10Zm-7.5-5H8.75V16.5H2.5Z" transform="translate(0 -4)" fill="#025B50"></path>
                                </svg>
                                <span>Bài viết liên quan</span>
                            </h2>
                        </div>
                        <div class="spr-content product-description-content article__content-posts">
                            <article>
                                <a target="_blank" href="" class="sforum__content-item button__link">
                                    <img src="https://cdn2.cellphones.com.vn/insecure/rs:fill:150:0/q:100/plain/https://cdn.sforum.vn/sforum/wp-content/uploads/2024/01/CareS-8-2-e1704785259475.jpg" alt="CareS - Trung tâm bảo hành ủy quyền Apple chính hãng tại Việt Nam" loading="lazy" class="content-item__img">
                                    <div class="content-item__text">CareS - Trung tâm bảo hành ủy quyền Apple chính hãng tại Việt Nam</div>
                                </a>
                            </article>

                            <article>
                                <a target="_blank" href="" class="sforum__content-item button__link">
                                    <img src="https://cdn2.cellphones.com.vn/insecure/rs:fill:150:0/q:100/plain/https://cdn.sforum.vn/sforum/wp-content/uploads/2024/01/CareS-8-2-e1704785259475.jpg" alt="CareS - Trung tâm bảo hành ủy quyền Apple chính hãng tại Việt Nam" loading="lazy" class="content-item__img">
                                    <div class="content-item__text">CareS - Trung tâm bảo hành ủy quyền Apple chính hãng tại Việt Nam</div>
                                </a>
                            </article>

                            <article>
                                <a target="_blank" href="" class="sforum__content-item button__link">
                                    <img src="https://cdn2.cellphones.com.vn/insecure/rs:fill:150:0/q:100/plain/https://cdn.sforum.vn/sforum/wp-content/uploads/2024/01/CareS-8-2-e1704785259475.jpg" alt="CareS - Trung tâm bảo hành ủy quyền Apple chính hãng tại Việt Nam" loading="lazy" class="content-item__img">
                                    <div class="content-item__text">CareS - Trung tâm bảo hành ủy quyền Apple chính hãng tại Việt Nam</div>
                                </a>
                            </article>

                            <article>
                                <a target="_blank" href="" class="sforum__content-item button__link">
                                    <img src="https://cdn2.cellphones.com.vn/insecure/rs:fill:150:0/q:100/plain/https://cdn.sforum.vn/sforum/wp-content/uploads/2024/01/CareS-8-2-e1704785259475.jpg" alt="CareS - Trung tâm bảo hành ủy quyền Apple chính hãng tại Việt Nam" loading="lazy" class="content-item__img">
                                    <div class="content-item__text">CareS - Trung tâm bảo hành ủy quyền Apple chính hãng tại Việt Nam</div>
                                </a>
                            </article>

                            <article>
                                <a target="_blank" href="" class="sforum__content-item button__link">
                                    <img src="https://cdn2.cellphones.com.vn/insecure/rs:fill:150:0/q:100/plain/https://cdn.sforum.vn/sforum/wp-content/uploads/2024/01/CareS-8-2-e1704785259475.jpg" alt="CareS - Trung tâm bảo hành ủy quyền Apple chính hãng tại Việt Nam" loading="lazy" class="content-item__img">
                                    <div class="content-item__text">CareS - Trung tâm bảo hành ủy quyền Apple chính hãng tại Việt Nam</div>
                                </a>
                            </article>

                            <article>
                                <a target="_blank" href="" class="sforum__content-item button__link">
                                    <img src="https://cdn2.cellphones.com.vn/insecure/rs:fill:150:0/q:100/plain/https://cdn.sforum.vn/sforum/wp-content/uploads/2024/01/CareS-8-2-e1704785259475.jpg" alt="CareS - Trung tâm bảo hành ủy quyền Apple chính hãng tại Việt Nam" loading="lazy" class="content-item__img">
                                    <div class="content-item__text">CareS - Trung tâm bảo hành ủy quyền Apple chính hãng tại Việt Nam</div>
                                </a>
                            </article>

                            <article>
                                <a target="_blank" href="" class="sforum__content-item button__link">
                                    <img src="https://cdn2.cellphones.com.vn/insecure/rs:fill:150:0/q:100/plain/https://cdn.sforum.vn/sforum/wp-content/uploads/2024/01/CareS-8-2-e1704785259475.jpg" alt="CareS - Trung tâm bảo hành ủy quyền Apple chính hãng tại Việt Nam" loading="lazy" class="content-item__img">
                                    <div class="content-item__text">CareS - Trung tâm bảo hành ủy quyền Apple chính hãng tại Việt Nam</div>
                                </a>
                            </article>

                            <article>
                                <a target="_blank" href="" class="sforum__content-item button__link">
                                    <img src="https://cdn2.cellphones.com.vn/insecure/rs:fill:150:0/q:100/plain/https://cdn.sforum.vn/sforum/wp-content/uploads/2024/01/CareS-8-2-e1704785259475.jpg" alt="CareS - Trung tâm bảo hành ủy quyền Apple chính hãng tại Việt Nam" loading="lazy" class="content-item__img">
                                    <div class="content-item__text">CareS - Trung tâm bảo hành ủy quyền Apple chính hãng tại Việt Nam</div>
                                </a>
                            </article>

                            <article>
                                <a target="_blank" href="" class="sforum__content-item button__link">
                                    <img src="https://cdn2.cellphones.com.vn/insecure/rs:fill:150:0/q:100/plain/https://cdn.sforum.vn/sforum/wp-content/uploads/2024/01/CareS-8-2-e1704785259475.jpg" alt="CareS - Trung tâm bảo hành ủy quyền Apple chính hãng tại Việt Nam" loading="lazy" class="content-item__img">
                                    <div class="content-item__text">CareS - Trung tâm bảo hành ủy quyền Apple chính hãng tại Việt Nam</div>
                                </a>
                            </article>
                        </div>

                        <a href="" class="act-button btn jsArticle btn-show-more-posts-related-product">
                            <span>Xem tất cả bài viết</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="10" height="10" class="icon-view-more">
                                <path d="M224 416c-8.188 0-16.38-3.125-22.62-9.375l-192-192c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L224 338.8l169.4-169.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-192 192C240.4 412.9 232.2 416 224 416z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
       </div>
    </div>
</section>

<section class="shopify-section section review-section">
    @include('frontend.pages.products.partials.product-review')
    </section>

<section class="shopify-section section review-section">
@include('frontend.pages.products.partials.suggested-products')
</section>

@include('frontend.pages.products.partials.gallery-image-modal')
@include('frontend.pages.products.partials.product-description-modal')
@include('frontend.pages.products.partials.product-review-modal')
@include('frontend.pages.products.partials.mobile-sale-actions')
@endsection

@section('js_script')
<script src="{{ asset_with_version('frontend/vendors/owl-carousel/dist/owl.carousel.min.js') }}" type="text/javascript"></script>
<script src="{{ asset_with_version('frontend/assets/js/components/owl-slider.js') }}" type="text/javascript"></script>
<script src="{{ asset_with_version('frontend/bundle/js/product-index.min.js') }}" type="text/javascript"></script>
<script src="{{ asset_with_version('frontend/bundle/js/flash-sale.min.js') }}" type="text/javascript"></script>
@endsection
