<div class="section-template--16599720329466__product-grid-padding">
    <div>
        @include('frontend.pages.collections.partials.collection-filters')
        <div class="product-grid-container" id="ProductGridContainer">
            <div class="collection page-width">
                <div class="loading-overlay gradient"></div>
                <div id="Infinite-Scroll-Loop" class="Infinite-Scroll-Loop">
                    <ul id="product-grid" class="grid product-grid grid--2-col-tablet-down grid--4-col-desktop" data-collection-linked-inventory="show-up"></ul>
                </div>
                <div id="Infinite-Scroll-Pagination" class="Infinite-Scroll-Pagination d-none" data-collection-linked-inventory="pagination">
                    <a class="button button--secondary" href="" data-current-page="1" data-next-page="2" data-collection-linked-inventory="btn_load_more">Xem Thêm</a>
                </div>
            </div>
        </div>
    </div>
</div>
