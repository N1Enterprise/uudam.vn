const SECTION_SCROLL = {
    init: () => {
        SECTION_SCROLL.onScroll();
        SECTION_SCROLL.handleScroll();
    },
    handleScroll: () => {
        var scrollPosition = $(window).scrollTop();

        $('[data-section][data-section-defer="true"]').each(function() {
            const offsetTop = $(this).offset().top;
            const offsetHei = $(this).outerHeight();

            if (
                scrollPosition >= (offsetTop - offsetHei - (offsetHei / 2))
                && scrollPosition < offsetTop + offsetHei
            ) {
                const sectionName = $(this).attr('data-section');
                const sectionNameSplited = sectionName.split(':');

                const type  = sectionNameSplited[0];
                const value = sectionNameSplited[1];

                switch (type) {
                    case 'home_page_display_1':
                        return SECTION_SCROLL.processHomePageDisplayScroll(sectionName, value);
                }
            }
        });
    },
    onScroll: () => {
        $(window).on('scroll', function() {
            SECTION_SCROLL.handleScroll();
        });
    },
    processHomePageDisplayScroll: (sectionName, value) => {
        $.ajax({
            url: HOME_PAGE_DISPLAY_ITEM_ROUTES.api_display_item_inventory.replace(':id', value),
            method: 'GET',
            beforeSend: () => {
                $(`[data-section="${sectionName}"]`).attr('data-section-defer', 'false');
            },
            success: (response) => {
                if (Array.isArray(response?.data) && response?.data?.length) {
                    $.each(response?.data, function(index, item) {
                        const dom = `
                            <div class="recommendation-target">
                                <a class="ls-link" data-product-identifier="${item.id}" href="${ CATALOG_ROUTES.web_product_detail.replace(':slug', item.slug) }">
                                    <div class="ls-image-wrap">
                                        <img class="ls-image image-lazy" alt="${ item.title }" title="${ item.title }" loading="lazy" sizes="270px" srcset="${ item.image }" src="${ item.image }" style="max-width: 270px; max-height: 270px; border-radius: 0px;">
                                    </div>
                                    <div class="ls-info-wrap">
                                        <div class="ls-title">${ item.title }</div>
                                        <div class="ls-vendor">${ item.product.branch }</div>
                                        <div class="ls-price-wrap">
                                            <span class="ls-original-price" style="display: none;"></span>
                                            <span class="ls-price money" data-numeric-value="${ item.sale_price }" data-money-convertible="">${ item.sale_price }</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        `;

                        $(`[data-recommendation-product-identifier=${item.id}]`).html(dom);
                    });
                }
            },
        });
    }
};

SECTION_SCROLL.init();