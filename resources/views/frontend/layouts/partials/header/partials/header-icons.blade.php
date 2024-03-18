<div class="header__icons">
    <details-modal class="header__search">
        <details>
            <summary class="header__icon header__icon--search header__icon--summary link focus-inset modal__toggle" aria-haspopup="dialog" aria-label="Search" role="button">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" role="presentation" class="icon icon-account" fill="none" viewBox="0 0 24 24" stroke="#000000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </span>
            </summary>
            <div class="search-modal modal__content gradient" role="dialog" aria-modal="true" aria-label="Search" style="z-index: 10000;">
                <div class="modal-overlay" close-modal-search></div>
                <div class="search-modal__content search-modal__content-bottom" tabindex="-1">
                    <predictive-search class="search-modal__form" data-loading-text="Loading..." results="true">
                        <form id="Form_Search_Master" action="/search" method="get" role="search" class="search search-modal__form" data-search-setting='@json(data_get($SYSTEM_SETTING, 'search_setting'))'>
                            <div class="field">
                                <input class="search__input field__input Search-In-Modal" type="search" name="q" value="" placeholder="Search" role="combobox" aria-expanded="false" aria-owns="predictive-search-results-list" aria-controls="predictive-search-results-list" aria-haspopup="listbox" aria-autocomplete="list" autocorrect="off" autocomplete="off" autocapitalize="off" spellcheck="false" aria-activedescendant="">
                                <label class="field__label" for="Search-In-Modal">{{ data_get($SYSTEM_SETTING, 'search_setting.placeholder', 'Tìm kiếm...') }}</label>
                                <button class="search__button field__button" aria-label="Search">
                                    <svg class="icon icon-search" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" viewBox="0 0 32 32" version="1.1">
                                        <title>search</title>
                                        <desc>Created with Sketch Beta.</desc>
                                        <defs></defs>
                                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                            <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-256.000000, -1139.000000)" fill="#000000">
                                                <path d="M269.46,1163.45 C263.17,1163.45 258.071,1158.44 258.071,1152.25 C258.071,1146.06 263.17,1141.04 269.46,1141.04 C275.75,1141.04 280.85,1146.06 280.85,1152.25 C280.85,1158.44 275.75,1163.45 269.46,1163.45 L269.46,1163.45 Z M287.688,1169.25 L279.429,1161.12 C281.591,1158.77 282.92,1155.67 282.92,1152.25 C282.92,1144.93 276.894,1139 269.46,1139 C262.026,1139 256,1144.93 256,1152.25 C256,1159.56 262.026,1165.49 269.46,1165.49 C272.672,1165.49 275.618,1164.38 277.932,1162.53 L286.224,1170.69 C286.629,1171.09 287.284,1171.09 287.688,1170.69 C288.093,1170.3 288.093,1169.65 287.688,1169.25 L287.688,1169.25 Z" id="search" sketch:type="MSShapeGroup"></path>
                                            </g>
                                        </g>
                                    </svg>
                                </button>
                            </div>
                            <div class="predictive-search predictive-search--header" tabindex="-1" data-predictive-search>
                                <div id="predictive-search-results">
                                    <div id="Predictive_Search_Product_Results" class="d-none">
                                        <h2 class="predictive-search__heading text-body caption-with-letter-spacing">Sản phẩm</h2>
                                        <ul class="predictive-search__results-list list-unstyled" role="listbox"></ul>
                                    </div>
                                    <div id="Predictive_Search_Post_Results" class="d-none">
                                        <h2 class="predictive-search__heading text-body caption-with-letter-spacing">Bài viết</h2>
                                        <ul class="predictive-search__results-list list-unstyled" role="listbox"></ul>
                                    </div>
                                    <div id="Predictive_Search_Collection_Results" class="d-none">
                                        <h2 class="predictive-search__heading text-body caption-with-letter-spacing">Bộ sưu tập</h2>
                                        <ul class="predictive-search__results-list list-unstyled" role="listbox"></ul>
                                    </div>
                                    <div id="Predictive_Search_Video_Results" class="d-none">
                                        <h2 class="predictive-search__heading text-body caption-with-letter-spacing">Video</h2>
                                        <ul class="predictive-search__results-list list-unstyled" role="listbox"></ul>
                                    </div>
                                    <div id="Predictive_Search_Other_Results" class="d-none">
                                        <h2 class="predictive-search__heading text-body caption-with-letter-spacing">Kết quả khác</h2>
                                        <ul class="predictive-search__results-list list-unstyled" role="listbox"></ul>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </predictive-search>
                    <button type="button" class="search-modal__close-button modal__close-button link link--text focus-inset" aria-label="Close" close-modal-search>
                        <svg xmlns="http://www.w3.org/2000/svg"  class="icon icon-close" viewBox="-0.5 0 25 25" fill="none">
                            <path d="M3 21.32L21 3.32001" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M3 3.32001L21 21.32" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            </div>
        </details>
    </details-modal>
    @if(empty($AUTHENTICATED_USER))
    <a href="?overlay=signin" class="header__icon header__icon--account link focus-inset small-hide" data-overlay-action-button="signin">
        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" role="presentation" class="icon icon-account" fill="none" viewBox="0 0 18 19">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M6 4.5a3 3 0 116 0 3 3 0 01-6 0zm3-4a4 4 0 100 8 4 4 0 000-8zm5.58 12.15c1.12.82 1.83 2.24 1.91 4.85H1.51c.08-2.6.79-4.03 1.9-4.85C4.66 11.75 6.5 11.5 9 11.5s4.35.26 5.58 1.15zM9 10.5c-2.5 0-4.65.24-6.17 1.35C1.27 12.98.5 14.93.5 18v.5h17V18c0-3.07-.77-5.02-2.33-6.15-1.52-1.1-3.67-1.35-6.17-1.35z" fill="currentColor"></path>
        </svg>
        <span class="visually-hidden">Log in</span>
    </a>
    @else
    <a href="{{ route('fe.web.user.profile') }}" class="header__icon header__icon--account link focus-inset small-hide" >
        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" role="presentation" class="icon icon-account" fill="none" viewBox="0 0 18 19">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M6 4.5a3 3 0 116 0 3 3 0 01-6 0zm3-4a4 4 0 100 8 4 4 0 000-8zm5.58 12.15c1.12.82 1.83 2.24 1.91 4.85H1.51c.08-2.6.79-4.03 1.9-4.85C4.66 11.75 6.5 11.5 9 11.5s4.35.26 5.58 1.15zM9 10.5c-2.5 0-4.65.24-6.17 1.35C1.27 12.98.5 14.93.5 18v.5h17V18c0-3.07-.77-5.02-2.33-6.15-1.52-1.1-3.67-1.35-6.17-1.35z" fill="currentColor"></path>
        </svg>
        <span class="visually-hidden">Profile</span>
    </a>
    @endif
    <a href="{{ route('fe.web.cart.index') }}" class="header__icon header__icon--cart link focus-inset" id="cart-icon-bubble">
        <svg class="icon icon-cart" aria-hidden="true" focusable="false" role="presentation" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" fill="none">
            <path fill="currentColor" fill-rule="evenodd" d="M20.5 6.5a4.75 4.75 0 00-4.75 4.75v.56h-3.16l-.77 11.6a5 5 0 004.99 5.34h7.38a5 5 0 004.99-5.33l-.77-11.6h-3.16v-.57A4.75 4.75 0 0020.5 6.5zm3.75 5.31v-.56a3.75 3.75 0 10-7.5 0v.56h7.5zm-7.5 1h7.5v.56a3.75 3.75 0 11-7.5 0v-.56zm-1 0v.56a4.75 4.75 0 109.5 0v-.56h2.22l.71 10.67a4 4 0 01-3.99 4.27h-7.38a4 4 0 01-4-4.27l.72-10.67h2.22z"></path>
        </svg>
        <span class="visually-hidden">Cart</span>
        <div class="cart-count-bubble">
            <span aria-hidden="true">
                <span data-value-cart-total-quantity>0</span>
            </span>
            <span class="visually-hidden">
                <span data-value-cart-total-quantity>0</span>
                item
            </span>
        </div>
    </a>
</div>
