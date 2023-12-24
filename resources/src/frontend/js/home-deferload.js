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
                scrollPosition >= (offsetTop - (offsetHei * 2))
                && scrollPosition < offsetTop + offsetHei
            ) {
                const sectionName = $(this).attr('data-section');
                const sectionNameSplited = sectionName.split(':');

                const type  = sectionNameSplited[0];
                const value = sectionNameSplited[1];

                switch (type) {
                    case 'home_page_display_1':
                        return SECTION_SCROLL.processHomePageDisplayInventoryScroll(sectionName, value);
                    case 'home_page_display_2':
                        return SECTION_SCROLL.processHomePageDisplayCollectionScroll(sectionName, value);
                    case 'home_page_display_3':
                        return SECTION_SCROLL.processHomePageDisplayPostScroll(sectionName, value);
                    case 'home_page_display_4':
                        return SECTION_SCROLL.processHomePageDisplayBlogScroll(sectionName, value);
                }
            }
        });
    },
    onScroll: () => {
        $(window).on('scroll', function() {
            SECTION_SCROLL.handleScroll();
        });
    },
    processHomePageDisplayInventoryScroll: (sectionName, value) => {
        $.ajax({
            url: HOME_PAGE_DISPLAY_ITEM_ROUTES.api_display_item_inventory.replace(':id', value),
            method: 'GET',
            beforeSend: () => {
                $(`[data-section="${sectionName}"]`).attr('data-section-defer', 'false');
            },
            success: (response) => {
                if (Array.isArray(response?.data) && response?.data?.length) {
                    $.each(response?.data, function(index, item) {
                        $(`[data-recommendation-product-identifier=${item.id}]`).html(`
                            <div class="recommendation-target">
                                <a class="ls-link" data-product-identifier="${item.id}" href="${ CATALOG_ROUTES.web_product_detail.replace(':slug', item.slug) }">
                                    <div class="ls-image-wrap">
                                        <img class="ls-image image-lazy" alt="${ item.title }" title="${ item.title }" loading="lazy" srcset="${ item.image }" src="${ item.image }" style="border-radius: 0px;">
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
                        `);
                    });
                }
            },
        });
    },
    processHomePageDisplayCollectionScroll: (sectionName, value) => {
        $.ajax({
            url: HOME_PAGE_DISPLAY_ITEM_ROUTES.api_display_item_collection.replace(':id', value),
            method: 'GET',
            beforeSend: () => {
                $(`[data-section="${sectionName}"]`).attr('data-section-defer', 'false');
            },
            success: (response) => {
                if (Array.isArray(response?.data) && response?.data?.length) {
                    $.each(response?.data, function(index, item) {
                        $(`[data-recommendation-collection-identifier=${item.id}]`).html(`
                            <div class="recommendation-target">
                                <div class="multicolumn-list__item grid__item slider__slide center" style="width: 100%;">
                                    <a href="${ CATALOG_ROUTES.web_collection_detail.replace(':slug', item.slug) }" style="text-decoration: none;">
                                        <div class="multicolumn-card content-container">
                                            <div class="multicolumn-card__image-wrapper multicolumn-card__image-wrapper--full-width">
                                                <div class="media media--transparent media--adapt">
                                                    <img class="multicolumn-card__image image-lazy" srcset="${ item.primary_image }" src="${ item.primary_image }" style="width: 100%; height: 100%;" alt="${ item.name }" loading="lazy">
                                                </div>
                                            </div>
                                            <div class="multicolumn-card__info" style="padding: 10px 0; text-align: left;">
                                                <div class="link animate-arrow" style="margin-top: 0; font-size: 18px;">
                                                    ${item.cta_label ? `
                                                        <span>${ item.cta_label }</span>
                                                        <span class="icon-wrap">&nbsp;
                                                            <svg viewBox="0 0 14 10" fill="none" aria-hidden="true" focusable="false" role="presentation" class="icon icon-arrow" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.537.808a.5.5 0 01.817-.162l4 4a.5.5 0 010 .708l-4 4a.5.5 0 11-.708-.708L11.793 5.5H1a.5.5 0 010-1h10.793L8.646 1.354a.5.5 0 01-.109-.546z" fill="currentColor"></path>
                                                            </svg>
                                                        </span>
                                                    ` : ''}
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        `);
                    });
                }
            },
        });
    },
    processHomePageDisplayPostScroll: (sectionName, value) => {
        $.ajax({
            url: HOME_PAGE_DISPLAY_ITEM_ROUTES.api_display_item_post.replace(':id', value),
            method: 'GET',
            beforeSend: () => {
                $(`[data-section="${sectionName}"]`).attr('data-section-defer', 'false');
            },
            success: (response) => {
                if (Array.isArray(response?.data) && response?.data?.length) {
                    $.each(response?.data, function(index, item) {
                        $(`[data-recommendation-post-identifier=${item.id}]`).html(`
                            <div class="recommendation-target">
                                <div class="blog__post article slider__slide slider__slide--full-width">
                                    <div class="card-wrapper underline-links-hover" style="width: 100%;">
                                        <div class="card article-card card--standard card--media">
                                            <div class="card__inner  color-background-2 gradient ratio" style="--ratio-percent: 60.24096385542169%;">
                                                <div class="article-card__image-wrapper card__media">
                                                    <div class="article-card__image media media--hover-effect">
                                                        <img class="image-lazy" srcset="${ item.image }" src="${ item.image }" sizes="(min-width: 1600px) 750px, (min-width: 750px) calc((100vw - 130px) / 2), calc((100vw - 50px) / 2)" alt="${ item.name }" class="motion-reduce" loading="lazy" width="2727" height="1818">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card__content">
                                                <div class="card__information">
                                                    <h3 class="card__heading h2">
                                                        <a href="${ CATALOG_ROUTES.web_post_detail.replace(':slug', item.slug) }" class="full-unstyled-link">${ item.name }</a>
                                                    </h3>
                                                    <div class="article-card__info caption-with-letter-spacing h5">
                                                        <span class="circle-divider">
                                                            <time datetime="${ item.post_at }">${ item.post_at }</time>
                                                        </span>
                                                    </div>
                                                    <p class="article-card__excerpt rte-width">${ item.description || '' }</p>
                                                    <div class="article-card__footer"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `);
                    });
                }
            },
        });
    },
    processHomePageDisplayBlogScroll: (sectionName, value) => {
        $.ajax({
            url: HOME_PAGE_DISPLAY_ITEM_ROUTES.api_display_item_blog.replace(':id', value),
            method: 'GET',
            beforeSend: () => {
                $(`[data-section="${sectionName}"]`).attr('data-section-defer', 'false');
            },
            success: (response) => {
                if (Array.isArray(response?.data) && response?.data?.length) {
                    $.each(response?.data, function(index, item) {
                        $(`[data-recommendation-blog-identifier=${item.id}]`).html(`
                            <div class="recommendation-target">
                                <div class="blog__post article slider__slide slider__slide--full-width">
                                    <div class="card-wrapper underline-links-hover" style="width: 100%;">
                                        <div class="card article-card card--standard card--media">
                                            <div class="card__inner  color-background-2 gradient ratio" style="--ratio-percent: 60.24096385542169%;">
                                                <div class="article-card__image-wrapper card__media">
                                                    <div class="article-card__image media media--hover-effect">
                                                        <img class="image-lazy" srcset="${ item.image }" src="${ item.image }" sizes="(min-width: 1600px) 750px, (min-width: 750px) calc((100vw - 130px) / 2), calc((100vw - 50px) / 2)" alt="${ item.name }" class="motion-reduce" loading="lazy" width="2727" height="1818">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card__content">
                                                <div class="card__information">
                                                    <h3 class="card__heading h2">
                                                        <a href="${ BLOG_ROUTES.web_detail.replace(':slug', item.slug) }" class="full-unstyled-link">${ item.name }</a>
                                                    </h3>
                                                    <p class="article-card__excerpt rte-width">${ item.description || '' }</p>
                                                    <div class="article-card__footer"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `);
                    });
                }
            },
        });
    }
};

SECTION_SCROLL.init();