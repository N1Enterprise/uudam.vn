<script>
$('.share-button__copy').on('click', function() {
    const text = $('#url.field__input').val();

    __HELPER__.copyClipBoard(text);
});

const PRODUCT_VARIANTS = {
    init: () => {
        PRODUCT_VARIANTS.onChange();
    },
    variant_resources: (() => {
        const data = $('#inventory_variants').attr('data-variants') || '{}';

        return JSON.parse(data);
    })(),
    onChange: () => {
        $('[name="attribute_value"]').on('change', function() {
            const value = $(this).val();
            const parent = $(this).parents('.attributes-item');

            parent.find('[name="attribute_value"]').prop('checked', false);
            parent.find('[name="attribute_value"]').parents('.label').removeClass('active');

            $(this).prop('checked', true);
            $(this).parents('.label').addClass('active');

            const product = PRODUCT_VARIANTS.findProductByAttribute();
        });
    },
    findProductByAttribute: () => {
        const conditions = {};

        $.each($('.label.active'), function(index, element) {
            conditions[ + ($(element).find('input').attr('data-attribute-id')) ] = + ($(element).find('input').val());
        });

        const product = PRODUCT_VARIANTS.variant_resources.find(function(item) {
            const attributes = item.attributes.map((item) => item.id);
            const attrValues = item.attribute_values.map((item) => item.id);

            const matches = (() => {
                if (
                    Object.keys(conditions).length == attributes.length
                    && Object.keys(conditions).every((id) => attributes.includes(+id))
                ) {
                    if (
                        Object.values(conditions).length == attrValues.length
                        && Object.values(conditions).every((id) => attrValues.includes(+id))
                    ) {
                        return true;
                    }
                }

                return false;
            })();

            return matches;
        });

        if (product) {
            PRODUCT_VARIANTS.renderProduct(product);
        }
    },
    renderProduct: (product) => {
        const { id, title, sku, sale_price, stock_quantity, image, slug } = product;

        const newHref = "{{ route('fe.web.products.show', ':slug') }}".replace(':slug', slug);

        $('[data-title]').text(title);
        $('[data-sku]').text(sku);
        $('[data-sale-price]').text(__HELPER__.formatNumber(sale_price)+' VND');
        $('[data-inventory-id]').text(id);
        $('[data-stock-quantity]').attr('max', stock_quantity);
        $('[data-image-index="0"]').attr('src', image);
        $('[data-image-index="0"]').attr('srcset', image);
        $('[data-url]').val(newHref);

        $(document).prop('title', title);

        PRODUCT_VARIANTS.renderIncludedProducts(product?.included_products || []);

        window.history.pushState('', '', newHref);
    },
    renderIncludedProducts: (includedProducts) => {
        const html = includedProducts?.map(function(item) {
            return `
            <div class="included-products__item">
                <div class="included-products__item-image" title="${item.description}">
                    <img src="${item.image}" alt="${item.name}" width="40" height="40">
                </div>

                <div class="included-products__item-info">
                    <div>
                        <h3 class="included-products-info-name" style="margin: 0">${item.name}</h3>
                        <span class="included-products-info-price">${__HELPER__.formatNumber(item.sale_price)+' VND'}</span>
                    </div>
                    <div>
                        <button type="button" class="included-products-info-order">Mua Kèm</button>
                    </div>
                </div>
            </div>
            `;
        }).join('');

        $('.included-products').html(html);
    },
};

const PRODUCT_OPEN_IMAGE_GALERIES = {
    close_element: $('[data-media-modal-close]'),
    open_element: $('[data-media-modal-open]'),
    video_iframe: $('#product-video-iframe'),
    init: () => {
        PRODUCT_OPEN_IMAGE_GALERIES.onOpen();
        PRODUCT_OPEN_IMAGE_GALERIES.onClose();
    },
    onOpen: () => {
        PRODUCT_OPEN_IMAGE_GALERIES.open_element.on('click', function() {
            $('.product-media-modal').attr('open', 'true');
        });
    },
    onClose: () => {
        PRODUCT_OPEN_IMAGE_GALERIES.close_element.on('click', function() {
            $('.product-media-modal').removeAttr('open');
            PRODUCT_OPEN_IMAGE_GALERIES.video_iframe.remove();
            setTimeout(() => { $('.product-media-modal__video').html(PRODUCT_OPEN_IMAGE_GALERIES.video_iframe) }, 100);
        });
    },
};

const PRODUCT_REVIEW = {
    init: () => {
        PRODUCT_REVIEW.onToggle();
        PRODUCT_REVIEW.onReview();
        PRODUCT_REVIEW.onKeyDownContent();
    },
    onToggle: () => {
        $('.spr-summary-actions-newreview').on('click', function() {
            $('[data-product-review]').toggleClass('d-none');
        });
    },
    onKeyDownContent: () => {
		const maxLength = 1000;

        $('.charactersremaining-count').text(maxLength);

        $('#Review_Product_Content').on('keydown', function() {
            count($(this).val());
        });

        $('#Review_Product_Content').on('paste', function() {
            count($(this).val());
        });

        function count(value) {
            const length = value.length;
            const charactersremaining = maxLength - length;

            if (charactersremaining >= 0) {
                $('.charactersremaining-count').text(charactersremaining);
            }
        }
    },
    onReview: () => {
        $('#User_Product_Review').on('submit', function(e) {
            e.preventDefault();

            const formData = $(this).serializeArray();
            const button = $('#User_Product_Review').find('button[type="submit"]');
            const ratingName = $('[name="rating_type"]').find(`option[value="${$('[name="rating_type"]').val()}"]`).text();

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                beforeSend: () => {
                    $(button).prop('disabled', true);
                },
                success: (response) => {
                    $(button).prop('disabled', false);
                    $('#User_Product_Review').trigger("reset");
                    $('.spr-summary-actions-newreview').trigger('click');
                    $('.product-review-empty').remove();

                    response.rating_type_name = ratingName;

                    PRODUCT_REVIEW.makeReviewHTML(response);
                },
                error: () => {
                    $(button).prop('disabled', false);
                },
            });
        });
    },
    makeReviewHTML: (response) => {
        const html = `
            <div class="spr-reviews" data-status="${response.status}" data-status-name="${response.status_name}">
                <div>Đánh giá của bạn đang được duyệt. Xin lỗi vì sự bất tiện này!</div>
                <div class="spr-review">
                    <div class="spr-review-header">
                        <span class="spr-starratings spr-review-header-starratings" role="img">
                            ${response.rating_type_name}
                        </span>
                        <h3 class="spr-review-header-title">${response.user_name}</h3>
                        <span class="spr-review-header-byline">
                            <strong>${moment(response.created_at).format("DD/MM/YYYY")}</strong>
                        </span>
                    </div>
                    <div class="spr-review-content">
                        <p class="spr-review-content-body">${response.content}</p>
                    </div>
                </div>
            </div>
        `;

        $('#shopify-product-reviews').find('.spr-content').append(html);
    }
};

PRODUCT_VARIANTS.init();
PRODUCT_OPEN_IMAGE_GALERIES.init();
PRODUCT_REVIEW.init();
</script>
