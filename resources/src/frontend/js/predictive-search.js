$('[close-modal-search]').on('click', function() {
    $('details-modal.header__search details[open]').removeAttr('open');
});

const PREDICTIVE_SEARCH = {
    init: () => {
        PREDICTIVE_SEARCH.onSuggest();
    },
    element: {
        form: $('#Form_Search_Master')
    },
    search_setting: JSON.parse($('[data-search-setting]').attr('data-search-setting') || '{}'),
    onSuggest: () => {
        $('.Search-In-Modal').on('input', function() {
            const query = $(this).val();

            utils_helper.debounce(PREDICTIVE_SEARCH.performSearch, 1000)(query);
        });
    },
    performSearch: (query) => {
        const data = {
            q: query,
            resources: {
                ...PREDICTIVE_SEARCH.search_setting?.resources
            },
        };

        if (!query.length) {
            PREDICTIVE_SEARCH.renderResultHTML({ htmlOfPosts: '', htmlOfInventories: '', htmlOfCollections: '', htmlSearchFor: '' });
            return;
        }

        $.ajax({
            url: SEARCH_ROUTES.api_suggest,
            method: 'GET',
            data,
            beforeSend: () => {
                $('predictive-search').attr('open', 'true');
                $('predictive-search').attr('loading', 'true');
                $('.predictive-search-status').attr('aria-hidden', false);
            },
            success: (response) => {
                const htmlOfPosts = PREDICTIVE_SEARCH.buildPostHtml(response?.posts || []);
                const htmlOfInventories = PREDICTIVE_SEARCH.buildInventoriesHtml(response?.inventories || []);
                const htmlOfCollections = PREDICTIVE_SEARCH.buildCollectionsHtml(response?.collections || []);
                const htmlOfOthersearch = PREDICTIVE_SEARCH.buildOthersearchHtml(response?.othersearch || []);

                PREDICTIVE_SEARCH.renderResultHTML({ htmlOfPosts, htmlOfInventories, htmlOfCollections, htmlOfOthersearch });
            },
        });
    },
    renderResultHTML: ({ htmlOfPosts, htmlOfInventories, htmlOfCollections, htmlOfOthersearch }) => {
        $('#Predictive_Search_Product_Results').toggleClass('d-none', !htmlOfInventories?.length);
        $('#Predictive_Search_Product_Results').find('ul.predictive-search__results-list').html(htmlOfInventories || '');

        $('#Predictive_Search_Post_Results').toggleClass('d-none', !htmlOfPosts?.length);
        $('#Predictive_Search_Post_Results').find('ul.predictive-search__results-list').html(htmlOfPosts || '');

        $('#Predictive_Search_Collection_Results').toggleClass('d-none', !htmlOfCollections?.length);
        $('#Predictive_Search_Collection_Results').find('ul.predictive-search__results-list').html(htmlOfCollections || '');

        $('#Predictive_Search_Other_Results').toggleClass('d-none', !htmlOfOthersearch?.length);
        $('#Predictive_Search_Other_Results').find('ul.predictive-search__results-list').html(htmlOfOthersearch || '');
    },
    buildPostHtml: (data = []) => {
        const html = data.map(function(item) {
            const route = POST_ROUTES.web_detail.replace(':slug', item.slug);

            return `
                <li class="predictive-search__list-item" role="option" aria-selected="false">
                    <a href="${route}" class="predictive-search__item predictive-search__item--link link link--text" tabindex="-1">
                        <img class="predictive-search__image" src="${item.image}" alt="${item.name}" width="50" height="50.0">
                        <div class="predictive-search__item-content predictive-search__item-content--centered">
                            <h3 class="predictive-search__item-heading h5">${item.name}</h3>
                        </div>
                    </a>
                </li>
            `;
        });

        return html.join('');
    },
    buildInventoriesHtml: (data = []) => {
        const html = data.map(function(item) {
            const route = PRODUCT_ROUTES.web_detail.replace(':slug', item.slug);

            return `
                <li class="predictive-search__list-item" role="option" aria-selected="false">
                    <a href="${route}" class="predictive-search__item predictive-search__item--link link link--text" tabindex="-1">
                        <img class="predictive-search__image" src="${item.image}" alt="${item.title}" width="50" height="50.0">
                        <div class="predictive-search__item-content predictive-search__item-content--centered">
                            <h3 class="predictive-search__item-heading h5">${item.title}</h3>
                        </div>
                    </a>
                </li>
            `;
        });

        return html.join('');
    },
    buildCollectionsHtml: (data = []) => {
        const html = data.map(function(item) {
            const route = COLLECTION_ROUTES.web_detail.replace(':slug', item.slug);

            return `
                <li class="predictive-search__list-item" role="option" aria-selected="false">
                    <a href="${route}" class="predictive-search__item predictive-search__item--link link link--text" tabindex="-1">
                        <img class="predictive-search__image" src="${item.primary_image}" alt="${item.name}" width="50" height="50.0">
                        <div class="predictive-search__item-content predictive-search__item-content--centered">
                            <h3 class="predictive-search__item-heading h5">${item.name}</h3>
                        </div>
                    </a>
                </li>
            `;
        });

        return html.join('');
    },
    buildOthersearchHtml: (data = []) => {
        const html = data.map(function(item) {
            const route = item.link;

            return `
                <li class="predictive-search__list-item" role="option" aria-selected="false">
                    <a href="${route}" target="${item.open_new_tab ? '_blank' : '_self'}" class="predictive-search__item predictive-search__item--link link link--text" tabindex="-1">
                        <img class="predictive-search__image" src="${item.image}" alt="${item.name}" width="50" height="50.0">
                        <div class="predictive-search__item-content predictive-search__item-content--centered">
                            <h3 class="predictive-search__item-heading h5">${item.name}</h3>
                        </div>
                    </a>
                </li>
            `;
        });

        return html.join('');
    }
};

PREDICTIVE_SEARCH.init();