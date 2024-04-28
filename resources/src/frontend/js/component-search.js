const SEARCH_INVENTORY = {
    elements: {
        show_up: $('[data-collection-linked-inventory="show-up"]'),
        btn_load_more: $('[data-collection-linked-inventory="btn_load_more"]'),
        sort_by: $('[data-collection-linked-inventory="sort_by"]'),
        pagination: $('[data-collection-linked-inventory="pagination"]'),
        total_product: $('[data-collection-linked-inventory="total_product"]'),
    },
    init: () => {
        SEARCH_INVENTORY.loadInitInventories();
        SEARCH_INVENTORY.loadMoreInventories();
        SEARCH_INVENTORY.loadBySortInventories();
    },
    ajaxInventories: (data = {}, { beforeSendCb, successCb, errorCb }) => {
        beforeSendCb = beforeSendCb || function() {};
        successCb = successCb || function() {};
        errorCb = errorCb || function() {};

        const payload = {
            paging: 'simplePaginate',
            per_page: 12,
            sort_by: SEARCH_INVENTORY.elements.sort_by.val(),
            page: SEARCH_INVENTORY.elements.btn_load_more.attr('data-current-page'),
            query: $('[data-search-query]').text(),
            ...data,
        };

        $.ajax({
            url: CATALOG_ROUTES.api_search_inventories,
            method: 'GET',
            data: payload,
            beforeSend: beforeSendCb,
            success: successCb,
            error: errorCb,
        });
    },
    loadBySortInventories: () => {
        SEARCH_INVENTORY.elements.sort_by.on('change', function() {
            const value = $(this).val();
            const currentPage = SEARCH_INVENTORY.elements.btn_load_more.attr('data-current-page');

            SEARCH_INVENTORY.elements.sort_by.find('option').prop('selected', false);
            SEARCH_INVENTORY.elements.sort_by.find(`option[value="${value}"]`).prop('selected', true);

            SEARCH_INVENTORY.ajaxInventories({ page: currentPage, sort_by: value, page: 1 }, {
                beforeSendCb: () => {
                    SEARCH_INVENTORY.elements.sort_by.prop('disabled', true);
                },
                successCb: (response) => {
                    const htmlInventories = SEARCH_INVENTORY.buildHTMLInventories(response?.data || []);

                    SEARCH_INVENTORY.elements.sort_by.prop('disabled', false);
                    SEARCH_INVENTORY.elements.show_up.html(htmlInventories);
                    SEARCH_INVENTORY.setPagination(response);
                    SEARCH_INVENTORY.updateUrl(response);
                    SEARCH_INVENTORY.countDisplayingProducts(response);
                },
            });
        });
    },
    loadMoreInventories: () => {
        SEARCH_INVENTORY.elements.btn_load_more.on('click', function(e) {
            e.preventDefault();

            const nextPage = $(this).attr('data-next-page');

            SEARCH_INVENTORY.ajaxInventories({ page: nextPage }, {
                beforeSendCb: () => {
                    SEARCH_INVENTORY.elements.btn_load_more.text('Loading...');
                },
                successCb: (response) => {
                    const htmlInventories = SEARCH_INVENTORY.buildHTMLInventories(response?.data || []);

                    SEARCH_INVENTORY.elements.show_up.append(htmlInventories);

                    SEARCH_INVENTORY.setPagination(response);
                    SEARCH_INVENTORY.updateUrl(response);
                    SEARCH_INVENTORY.countDisplayingProducts(response);
                },
            });
        });
    },
    loadInitInventories: () => {
        SEARCH_INVENTORY.ajaxInventories({  }, {
            beforeSendCb: () => {
                SEARCH_INVENTORY.elements.pagination.addClass('d-none');
                SEARCH_INVENTORY.elements.show_up.html('<div>Loading ...</div>');
            },
            successCb: (response) => {
                const htmlInventories = SEARCH_INVENTORY.buildHTMLInventories(response?.data || []);

                SEARCH_INVENTORY.elements.show_up.html(htmlInventories);
                SEARCH_INVENTORY.setPagination(response);
                SEARCH_INVENTORY.updateUrl(response);
                SEARCH_INVENTORY.countDisplayingProducts(response);
            },
        });
    },
    setPagination: (response) => {
        SEARCH_INVENTORY.elements.btn_load_more.attr('data-current-page', response.current_page);

        if (response?.has_more && response?.current_page) {
            SEARCH_INVENTORY.elements.pagination.removeClass('d-none');
            SEARCH_INVENTORY.elements.btn_load_more.text('Xem Thêm');
            SEARCH_INVENTORY.elements.btn_load_more.attr('href', `${SEARCH_INVENTORY.baseRoute}?page=${response.current_page + 1}`);
            SEARCH_INVENTORY.elements.btn_load_more.attr('data-next-page', response.current_page + 1);
        } else {
            SEARCH_INVENTORY.elements.pagination.addClass('d-none');
            SEARCH_INVENTORY.elements.btn_load_more.html('');
        }
    },
    countDisplayingProducts: (response) => {
        const totalCount = $('[data-collection-linked-inventory="show-up"] li').length;

        SEARCH_INVENTORY.elements.total_product.attr('data-total', totalCount);
        SEARCH_INVENTORY.elements.total_product.text(totalCount);
    },
    updateUrl: (response) => {
    },
    buildHTMLInventories: (inventories) => {
        const _html = inventories.map((inventory) => {
            const route = PRODUCT_ROUTES.web_detail.replace(':slug', inventory?.slug);

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
                                <a href="${ route }" class="full-unstyled-link" style="text-decoration: none;">${ inventory?.title }</a>
                                </h3>
                                <div class="card-information" style="padding: 4px 0;">
                                    <div class="price">
                                        <div class="ls-reviewer">
                                            ${ inventory?.product?.positive_review_count ? `<b>${inventory?.product?.positive_review_count}</b> đáng giá tích cực` : '' }
                                        </div>
                                        <div class="price__regular">
                                            <div class="ls-price-group">
                                                <div>
                                                    <span class="price-item price-item--regular">${inventory.final_price} </span>
                                                    ${ inventory.has_offer_price ? `<del class="price-item--sub">${ inventory.sub_price }</del>` : '' }
                                                </div>
                                                <span class="sold-count">Đã bán ${ inventory.final_sold_count }</span>
                                            </div>

                                            ${
                                                inventory.has_offer_price ? `
                                                    <span class="price-discount-percent discount-absolute">-${ inventory.discount_percent }%</span>
                                                    <div class="price-for-saving">(Tiết kiệm <span>${ inventory.price_for_saving }</span>)</div>
                                                ` : ''
                                            }
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="quick-add">
                                <a type="submit" name="add" class="quick-add__submit button button--full-width button--secondary" data-product-url="${ route }" href="${ route }">
                                    Xem Chi Tiết
                                    <div class="loading-overlay__spinner hidden">
                                        <svg focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
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

SEARCH_INVENTORY.init();
