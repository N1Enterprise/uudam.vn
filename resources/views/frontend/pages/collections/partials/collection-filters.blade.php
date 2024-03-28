<aside aria-labelledby="verticalTitle" class="facets-wrapper page-width" id="main-collection-filters">
    <div class="facets-container">
        <facet-filters-form class="facets small-hide">
            <form id="FacetFiltersForm" class="facets__form">
                <div class="facet-filters sorting caption">
                    <div class="facet-filters__field">
                        <h2 class="facet-filters__label caption-large text-body">
                            <label for="SortBy">Lọc sản phẩm theo:</label>
                        </h2>
                        <div class="select">
                            <select name="sort_by" data-collection-linked-inventory="sort_by" class="facet-filters__sort select__select caption-large" id="SortBy" aria-describedby="a11y-refresh-page-message">
                                <option value="manual" selected="selected">Nổi bật</option>
                                <option value="best-selling">Bán chạy nhất</option>
                                <option value="title-ascending">Theo bảng chữ cái, A-Z</option>
                                <option value="title-descending">Theo bảng chữ cái, Z-A</option>
                                <option value="price-ascending">Giá từ thấp đến cao</option>
                                <option value="price-descending">Giá từ cao đến thấp</option>
                                <option value="created-ascending">Ngày, cũ đến mới</option>
                                <option value="created-descending">Ngày, mới đến cũ</option>
                            </select>
                            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-caret" viewBox="0 0 10 6">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.354.646a.5.5 0 00-.708 0L5 4.293 1.354.646a.5.5 0 00-.708.708l4 4a.5.5 0 00.708 0l4-4a.5.5 0 000-.708z" fill="currentColor"></path>
                            </svg>
                        </div>
                    </div>
                    <noscript>
                        <button type="submit" class="facets__button-no-js button button--secondary">Sắp xếp</button>
                    </noscript>
                </div>
                <div class="product-count light" role="status">
                    <h2 class="product-count__text text-body">
                        <span id="ProductCountDesktop"><span data-collection-linked-inventory="total_product" data-total="0">0</span> sản phẩm </span>
                    </h2>
                    <div class="loading-overlay__spinner">
                        <svg aria-hidden="true" focusable="false" role="presentation" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                            <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                        </svg>
                    </div>
                </div>
            </form>
        </facet-filters-form>
        <menu-drawer class="mobile-facets__wrapper medium-hide large-up-hide" data-breakpoint="mobile">
            <details class="mobile-facets__disclosure disclosure-has-popup">
                <summary class="mobile-facets__open-wrapper focus-offset" data-collection-mobile-filter-close>
                    <span class="mobile-facets__open" data-collection-mobile-filter-open>
                        <svg class="icon icon-filter" aria-hidden="true" focusable="false" role="presentation" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none">
                            <path fill-rule="evenodd" d="M4.833 6.5a1.667 1.667 0 1 1 3.334 0 1.667 1.667 0 0 1-3.334 0ZM4.05 7H2.5a.5.5 0 0 1 0-1h1.55a2.5 2.5 0 0 1 4.9 0h8.55a.5.5 0 0 1 0 1H8.95a2.5 2.5 0 0 1-4.9 0Zm11.117 6.5a1.667 1.667 0 1 0-3.334 0 1.667 1.667 0 0 0 3.334 0ZM13.5 11a2.5 2.5 0 0 1 2.45 2h1.55a.5.5 0 0 1 0 1h-1.55a2.5 2.5 0 0 1-4.9 0H2.5a.5.5 0 0 1 0-1h8.55a2.5 2.5 0 0 1 2.45-2Z" fill="currentColor"></path>
                        </svg>
                        <span class="mobile-facets__open-label button-label medium-hide large-up-hide">Lọc và sắp xếp</span>
                        <span class="mobile-facets__open-label button-label small-hide">Bộ lọc</span>
                    </span>
                    <span tabindex="0" class="mobile-facets__close mobile-facets__close--no-js" data-collection-mobile-filter-close>
                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" role="presentation" class="icon icon-close" fill="none" viewBox="0 0 18 17">
                            <path d="M.865 15.978a.5.5 0 00.707.707l7.433-7.431 7.579 7.282a.501.501 0 00.846-.37.5.5 0 00-.153-.351L9.712 8.546l7.417-7.416a.5.5 0 10-.707-.708L8.991 7.853 1.413.573a.5.5 0 10-.693.72l7.563 7.268-7.418 7.417z" fill="currentColor"></path>
                        </svg>
                    </span>
                </summary>
                <facet-filters-form>
                    <form id="FacetFiltersFormMobile" class="mobile-facets">
                        <div class="mobile-facets__inner gradient">
                            <div class="mobile-facets__header">
                                <div class="mobile-facets__header-inner">
                                    <h2 class="mobile-facets__heading medium-hide large-up-hide">Lọc và sắp xếp</h2>
                                    <h2 class="mobile-facets__heading small-hide">Bộ lọc</h2>
                                    <p class="mobile-facets__count"><span data-collection-linked-inventory="total_product" data-total="0">0</span> sản phẩm </p>
                                </div>
                            </div>
                            <div class="mobile-facets__main has-submenu gradient">
                                <div class="mobile-facets__details js-filter">
                                    <div class="mobile-facets__summary">
                                        <div class="mobile-facets__sort">
                                            <label for="SortBy-mobile">Lọc sản phẩm theo:</label>
                                            <div class="select">
                                                <select name="sort_by" data-collection-linked-inventory="sort_by" class="select__select" id="SortBy-mobile" aria-describedby="a11y-refresh-page-message">
                                                    <option value="manual" selected="selected">Nổi bật</option>
                                                    <option value="best-selling">Bán chạy nhất</option>
                                                    <option value="title-ascending">Theo bảng chữ cái, A-Z</option>
                                                    <option value="title-descending">Theo bảng chữ cái, Z-A</option>
                                                    <option value="price-ascending">Giá từ thấp đến cao</option>
                                                    <option value="price-descending">Giá từ cao đến thấp</option>
                                                    <option value="created-ascending">Ngày, cũ đến mới</option>
                                                    <option value="created-descending">Ngày, mới đến cũ</option>
                                                </select>
                                                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-caret" viewBox="0 0 10 6">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M9.354.646a.5.5 0 00-.708 0L5 4.293 1.354.646a.5.5 0 00-.708.708l4 4a.5.5 0 00.708 0l4-4a.5.5 0 000-.708z" fill="currentColor"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </facet-filters-form>
            </details>
        </menu-drawer>
        <div class="product-count light medium-hide large-up-hide" role="status">
            <h2 class="product-count__text text-body">
                <span id="ProductCount"><span data-collection-linked-inventory="total_product" data-total="0">0</span> sản phẩm</span>
            </h2>
            <div class="loading-overlay__spinner">
                <svg aria-hidden="true" focusable="false" role="presentation" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                    <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                </svg>
            </div>
        </div>
    </div>
</aside>
