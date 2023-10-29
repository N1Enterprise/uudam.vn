@extends('frontend.layouts.master')

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
    const COLLECTION_INVENTORY = {
        init: () => {
            COLLECTION_INVENTORY.onReadMore();
        },
        onReadMore: () => {
            $('#btnreadmore').on('click', function() {
                const isExpaned = $('.collection-hero__description').hasClass('read_more_span--clamp');

                $('.collection-hero__description').toggleClass('read_more_span--clamp', !isExpaned);
                $(this).text(!isExpaned ? 'Rút Gọn' : 'Xem Thêm');
            });
        },
    };

    const COLLECTION_LINKED_INVENTORIES = {
        baseRoute: "{{ route('fe.api.user.collections.linked-inventories', ':id') }}".replace(':id', "{{ $collection->id }}"),
        init: () => {
            COLLECTION_LINKED_INVENTORIES.loadInitInventories();
            COLLECTION_LINKED_INVENTORIES.loadMoreInventories();
            COLLECTION_LINKED_INVENTORIES.loadBySortInventories();
        },
        elements: {
            show_up: $('[data-collection-linked-inventory="show-up"]'),
            btn_load_more: $('[data-collection-linked-inventory="btn_load_more"]'),
            sort_by: $('[data-collection-linked-inventory="sort_by"]'),
            pagination: $('[data-collection-linked-inventory="pagination"]'),
            total_product: $('[data-collection-linked-inventory="total_product"]'),
        },
        ajaxInventories: (data = {}, { beforeSendCb, successCb, errorCb }) => {
            beforeSendCb = beforeSendCb || function() {};
            successCb = successCb || function() {};
            errorCb = errorCb || function() {};

            $.ajax({
                url: COLLECTION_LINKED_INVENTORIES.baseRoute,
                method: 'GET',
                data: {
                    paging: 'simplePaginate',
                    per_page: 12,
                    sort_by: COLLECTION_LINKED_INVENTORIES.elements.sort_by.val(),
                    page: COLLECTION_LINKED_INVENTORIES.elements.btn_load_more.attr('data-current-page'),
                    ...data,
                },
                beforeSend: beforeSendCb,
                success: successCb,
                error: errorCb,
            });
        },
        loadInitInventories: () => {
            COLLECTION_LINKED_INVENTORIES.ajaxInventories({  }, {
                beforeSendCb: () => {
                    COLLECTION_LINKED_INVENTORIES.elements.pagination.addClass('d-none');
                    COLLECTION_LINKED_INVENTORIES.elements.show_up.html('<div>Loading ...</div>');
                },
                successCb: (response) => {
                    const htmlInventories = COLLECTION_LINKED_INVENTORIES.buildHTMLInventories(response?.data || []);

                    COLLECTION_LINKED_INVENTORIES.elements.show_up.html(htmlInventories);

                    COLLECTION_LINKED_INVENTORIES.setPagination(response);
                    COLLECTION_LINKED_INVENTORIES.updateUrl(response);
                    COLLECTION_LINKED_INVENTORIES.countDisplayingProducts(response);
                }
            });
        },
        loadMoreInventories: () => {
            COLLECTION_LINKED_INVENTORIES.elements.btn_load_more.on('click', function(e) {
                e.preventDefault();

                const nextPage = $(this).attr('data-next-page');

                COLLECTION_LINKED_INVENTORIES.ajaxInventories({ page: nextPage }, {
                    beforeSendCb: () => {
                        COLLECTION_LINKED_INVENTORIES.elements.btn_load_more.text('Loading...');
                    },
                    successCb: (response) => {
                        const htmlInventories = COLLECTION_LINKED_INVENTORIES.buildHTMLInventories(response?.data || []);

                        COLLECTION_LINKED_INVENTORIES.elements.show_up.append(htmlInventories);

                        COLLECTION_LINKED_INVENTORIES.setPagination(response);
                        COLLECTION_LINKED_INVENTORIES.updateUrl(response);
                        COLLECTION_LINKED_INVENTORIES.countDisplayingProducts(response);
                    },
                });
            });
        },
        loadBySortInventories: () => {
            COLLECTION_LINKED_INVENTORIES.elements.sort_by.on('change', function() {
                const value = $(this).val();
                const currentPage = COLLECTION_LINKED_INVENTORIES.elements.btn_load_more.attr('data-current-page');

                COLLECTION_LINKED_INVENTORIES.ajaxInventories({ page: currentPage, sort_by: value }, {
                    beforeSendCb: () => {
                        COLLECTION_LINKED_INVENTORIES.elements.sort_by.prop('disabled', true);
                    },
                    successCb: (response) => {
                        const htmlInventories = COLLECTION_LINKED_INVENTORIES.buildHTMLInventories(response?.data || []);

                        COLLECTION_LINKED_INVENTORIES.elements.sort_by.prop('disabled', false);
                        COLLECTION_LINKED_INVENTORIES.elements.show_up.html(htmlInventories);
                        COLLECTION_LINKED_INVENTORIES.setPagination(response);
                        COLLECTION_LINKED_INVENTORIES.updateUrl(response);
                        COLLECTION_LINKED_INVENTORIES.countDisplayingProducts(response);
                    },
                });
            });
        },
        countDisplayingProducts: (response) => {
            const currentTotal = + (COLLECTION_LINKED_INVENTORIES.elements.total_product.attr('data-total') || 0);
            const currentPage  = response?.current_page;
            const countItems   = response?.data?.length || 0;

            const finalTotal = (12 * currentPage) - (12 - countItems);

            COLLECTION_LINKED_INVENTORIES.elements.total_product.attr('data-total', finalTotal);
            COLLECTION_LINKED_INVENTORIES.elements.total_product.text(finalTotal);
        },
        setPagination: (response) => {
            COLLECTION_LINKED_INVENTORIES.elements.btn_load_more.attr('data-current-page', response.current_page);

            if (response?.has_more && response?.current_page) {
                COLLECTION_LINKED_INVENTORIES.elements.pagination.removeClass('d-none');
                COLLECTION_LINKED_INVENTORIES.elements.btn_load_more.text('Xem Thêm');
                COLLECTION_LINKED_INVENTORIES.elements.btn_load_more.attr('href', `${COLLECTION_LINKED_INVENTORIES.baseRoute}?page=${response.current_page + 1}`);
                COLLECTION_LINKED_INVENTORIES.elements.btn_load_more.attr('data-next-page', response.current_page + 1);
            } else {
                COLLECTION_LINKED_INVENTORIES.elements.pagination.addClass('d-none');
                COLLECTION_LINKED_INVENTORIES.elements.btn_load_more.html('');
            }
        },
        updateUrl: (response) => {
        },
        buildHTMLInventories: (inventories) => {
            const _html = inventories.map((inventory) => {
                const route = "{{ route('fe.web.products.index', ':slug') }}".replace(':slug', inventory?.slug);

                return `
                <li class="grid__item">
                    <div class="card-wrapper underline-links-hover">
                        <div class="card card--standard card--media" style="--ratio-percent: 100%;">
                            <div class="card__inner color-background-2 gradient ratio" style="--ratio-percent: 100%;">
                                <div class="card__media">
                                    <div class="media media--transparent media--hover-effect">
                                        <img srcset="${ inventory?.image }" src="${ inventory?.image }" sizes="(min-width: 1600px) 367px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)" alt="${ inventory?.title }" class="motion-reduce" width="1000" height="1000">
                                    </div>
                                </div>
                                <div class="card__content">
                                    <div class="card__information">
                                        <h3 class="card__heading">
                                            <a href="${ route }" class="full-unstyled-link">${ inventory?.title }</a>
                                        </h3>
                                    </div>
                                    <div class="card__badge bottom left"></div>
                                </div>
                            </div>
                            <div class="card__content">
                                <div class="card__information">
                                    <h3 class="card__heading h5">
                                        <a href="${ route }" class="full-unstyled-link">${ inventory?.title }</a>
                                    </h3>
                                    <div class="card-information">
                                        <span class="caption-large light"></span>
                                        <div class="price ">
                                            <div class="price__container">
                                                <div class="price__regular">
                                                    <span class="visually-hidden visually-hidden--inline">Giá cả phải chăng</span>
                                                    <span class="price-item price-item--regular"> Giá từ ${inventory.sale_price} </span>
                                                </div>
                                                <div class="price__sale">
                                                    <span class="visually-hidden visually-hidden--inline">Giá cả phải chăng</span>
                                                    <span>
                                                    <s class="price-item price-item--regular"></s>
                                                    </span>
                                                    <span class="visually-hidden visually-hidden--inline">Sale price</span>
                                                    <span class="price-item price-item--sale price-item--last"> Giá từ ${inventory.sale_price} </span>
                                                </div>
                                                <small class="unit-price caption hidden">
                                                <span class="visually-hidden">Unit price</span>
                                                <span class="price-item price-item--last">
                                                <span></span>
                                                <span aria-hidden="true">/</span>
                                                <span class="visually-hidden">&nbsp;per&nbsp;</span>
                                                <span></span>
                                                </span>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="quick-add">
                                    <a type="submit" name="add" class="quick-add__submit button button--full-width button--secondary" aria-haspopup="dialog" data-product-url="${ route }" href="${ route }">
                                        Xem Chi Tiết
                                        <div class="loading-overlay__spinner hidden">
                                            <svg aria-hidden="true" focusable="false" role="presentation" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                                                <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                                            </svg>
                                        </div>
                                    </a>
                                </div>
                                <div class="card__badge bottom left"></div>
                            </div>
                        </div>
                    </div>
                </li>
                `;
            });

            return _html.join('');
        },
    };

    COLLECTION_INVENTORY.init();
    COLLECTION_LINKED_INVENTORIES.init();
</script>
@endpush
