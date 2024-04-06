<div class="product-modal-description">
    <product-modal data-description-modal-close class="product-media-modal media-modal">
        <button type="button" class="product-media-modal__toggle">
            <svg xmlns="http://www.w3.org/2000/svg" focusable="false" class="icon icon-close" fill="none" viewBox="0 0 18 17">
                <path d="M.865 15.978a.5.5 0 00.707.707l7.433-7.431 7.579 7.282a.501.501 0 00.846-.37.5.5 0 00-.153-.351L9.712 8.546l7.417-7.416a.5.5 0 10-.707-.708L8.991 7.853 1.413.573a.5.5 0 10-.693.72l7.563 7.268-7.418 7.417z" fill="currentColor"></path>
            </svg>
        </button>
        <div class="product-media-modal__content gradient" tabindex="0">
            <div class="spr-header">
                <h2 class="spr-header-title" style="text-align: left;">Mô tả sản phẩm</h2>
            </div>
            <div class="spr-content product-description-content">
                {!! data_get($inventory, 'product.description') !!}
            </div>
            <button type="button" class="act-button" data-description-modal-close class="button" style="margin-top: 10px;">Đã đọc xong</button>
        </div>
    </product-modal>
</div>
