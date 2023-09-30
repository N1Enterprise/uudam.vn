<details-modal class="header__search">
    <details>
      <summary class="header__icon header__icon--search header__icon--summary link focus-inset modal__toggle" aria-haspopup="dialog" aria-label="Search" role="button">
        <span>
          <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" role="presentation" class="icon icon-account" fill="none" viewBox="0 0 24 24" stroke="#000000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
          <svg class="modal__toggle-close icon icon-close" aria-hidden="true" focusable="false" role="presentation">
            <use href="#icon-close">
          </use></svg>
        </span>
      </summary>
      <div class="search-modal modal__content gradient" role="dialog" aria-modal="true" aria-label="Search">
        <div class="modal-overlay"></div>
        <div class="search-modal__content search-modal__content-bottom" tabindex="-1"><predictive-search class="search-modal__form" data-loading-text="Loading..."><form action="/search" method="get" role="search" class="search search-modal__form">
              <div class="field">
                <input class="search__input field__input" id="Search-In-Modal" type="search" name="q" value="" placeholder="Search" role="combobox" aria-expanded="false" aria-owns="predictive-search-results-list" aria-controls="predictive-search-results-list" aria-haspopup="listbox" aria-autocomplete="list" autocorrect="off" autocomplete="off" autocapitalize="off" spellcheck="false" aria-activedescendant="">
                <label class="field__label" for="Search-In-Modal">Search</label>
                <input type="hidden" name="options[prefix]" value="last">
                <button class="search__button field__button" aria-label="Search">
                  <svg class="icon icon-search" aria-hidden="true" focusable="false" role="presentation">
                    <use href="#icon-search">
                  </use></svg>
                </button>
              </div><div class="predictive-search predictive-search--header" tabindex="-1" data-predictive-search="">
                  <div class="predictive-search__loading-state">
                    <svg aria-hidden="true" focusable="false" role="presentation" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                      <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                    </svg>
                  </div>
                </div>

                <span class="predictive-search-status visually-hidden" role="status" aria-hidden="true"></span></form></predictive-search><button type="button" class="search-modal__close-button modal__close-button link link--text focus-inset" aria-label="Close">
            <svg class="icon icon-close" aria-hidden="true" focusable="false" role="presentation">
              <use href="#icon-close">
            </use></svg>
          </button>
        </div>
      </div>
    </details>
  </details-modal>
