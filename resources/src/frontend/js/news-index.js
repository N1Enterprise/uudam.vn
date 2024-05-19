const POST_BY = {
    baseRoute: (() => {
        const activeCategory = $('[data-active-category]').attr('data-active-category');

        if (activeCategory) {
            return POST_ROUTES.api_post_by_category.replace(':category', activeCategory);
        }

        return POST_ROUTES.api_post_by_suggestion;
    })(),
    elements: {
        show_up: $('[data-news-post="show-up"]'),
        btn_load_more: $('[data-news-post="btn_load_more"]'),
        pagination: $('[data-news-post="pagination"]'),
    },
    init: () => {
        POST_BY.loadInit();
        POST_BY.loadMore();
    },
    loadInit: () => {
        POST_BY.ajaxInventories({  }, {
            beforeSendCb: () => {
                POST_BY.elements.pagination.addClass('d-none');
                // POST_BY.elements.show_up.html('<div>Loading ...</div>');
            },
            successCb: (response) => {
                if (! response?.data?.length) {
                    return;
                }

                const htmlPosts = POST_BY.buildHTML(response?.data || []);
                POST_BY.elements.show_up.html(htmlPosts);
                POST_BY.setPagination(response);
            }
        });
    },
    setPagination: (response) => {
        POST_BY.elements.btn_load_more.attr('data-current-page', response.current_page);

        if (response?.has_more && response?.current_page) {
            POST_BY.elements.pagination.removeClass('d-none');
            POST_BY.elements.btn_load_more.find('.text').text('Xem Thêm');
            POST_BY.elements.btn_load_more.attr('href', `${POST_BY.baseRoute}?page=${response.current_page + 1}`);
            POST_BY.elements.btn_load_more.attr('data-next-page', response.current_page + 1);
        } else {
            POST_BY.elements.pagination.addClass('d-none');
            // POST_BY.elements.btn_load_more.html('');
        }
    },
    buildHTML: (posts) => {
        const _html = posts.map((post) => {
            const route = POST_ROUTES.web_detail.replace(':slug', post.slug);

            return `
            <div class="news-content__articles-item">
                <a class="articles-item__image" href="${ route }">
                    <img src="${ post.image }" alt="${ post.name }" loading="lazy" width="300" height="300" style="color: transparent;">
                </a>
                <div class="articles-item__content">
                    <a class="articles-item__content-heading" href="${ route }">
                        <h3>${ post.name }</h3>
                    </a>
                    <p class="articles-item__content-desc">${ post.description }</p>
                    <div class="articles-item__content-metadata">
                        <a class="articles-item__content-author" href="/sforum/author/quannguyen">
                            <span>${ post?.author || 'uudam.vn' }</span>
                        </a>
                        <span class="articles-item__content-datetime">
                            <span>${ post.post_at }</span>
                        </span>
                    </div>
                </div>
            </div>
            `;
        });

        return _html.join('');
    },
    loadMore: () => {
        POST_BY.elements.btn_load_more.on('click', function(e) {
            e.preventDefault();

            const nextPage = $(this).attr('data-next-page');

            POST_BY.ajaxInventories({ page: nextPage }, {
                beforeSendCb: () => {
                    POST_BY.elements.btn_load_more.find('.text').text('Loading...');
                },
                successCb: (response) => {
                    const postHtml = POST_BY.buildHTML(response?.data || []);
                    POST_BY.elements.show_up.append(postHtml);
                    POST_BY.setPagination(response);
                },
            });
        });
    },
    ajaxInventories: (data = {}, { beforeSendCb, successCb, errorCb }) => {
        beforeSendCb = beforeSendCb || function() {};
        successCb = successCb || function() {};
        errorCb = errorCb || function() {};

        const payload = {
            paging: 'simplePaginate',
            per_page: 20,
            page: POST_BY.elements.btn_load_more.attr('data-current-page'),
            ...data,
        };

        $.ajax({
            url: POST_BY.baseRoute,
            method: 'GET',
            data: payload,
            beforeSend: beforeSendCb,
            success: successCb,
            error: errorCb,
        });
    },
};

POST_BY.init();
