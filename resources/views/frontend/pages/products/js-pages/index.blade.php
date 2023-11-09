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

        const newHref = "{{ route('fe.web.products.index', ':slug') }}".replace(':slug', slug);

        $('[data-title]').text(title);
        $('[data-sku]').text(sku);
        $('[data-sale-price]').text(__HELPER__.formatNumber(sale_price)+' VND');
        $('[data-inventory-id]').text(id);
        $('[data-stock-quantity]').attr('max', stock_quantity);
        $('[data-image-index="0"]').attr('src', image);
        $('[data-image-index="0"]').attr('srcset', image);
        $('[data-url]').val(newHref);

        $(document).prop('title', title);

        PRODUCT_VARIANTS.renderProductCombos(product?.product_combos || []);

        window.history.pushState('', '', newHref);
    },
    renderProductCombos: (productCombos) => {
        $('.product-combos').toggleClass('d-none', !productCombos.length);
        // $('[data-product-combo-confirm]').prop('checked', false);
        // $('[data-product-combo-confirm]').trigger('change');

        const html = productCombos?.map(function(item) {
            return `
            <div class="product-combos__item">
                <div class="product-combos__item-image" title="${item.description}">
                    <img src="${item.image}" alt="test">
                </div>

                <div class="product-combos__item-info">
                    <div>
                        <h3 class="product-combos-info-name" style="margin: 0">${item.name}</h3>
                        <span class="product-combos-info-price">${__HELPER__.formatNumber(item.sale_price)}</span>
                    </div>
                    <div class="product-combos__item-sale">
                        <div class="product-form__input product-form__quantity">
                            <span>${item.pivot.quantity} ${item.unit}</span>
                        </div>
                    </div>
                </div>
            </div>
            `;
        }).join('');

        $('[data-product-combo-list]').html(html);
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

const MAIN_PRODUCT_QUANTITY = {
    elements: {
        btn_increase: $('[data-quantity-button="increase"]'),
        btn_decrease: $('[data-quantity-button="decrease"]'),
        input_quantity: $('.quantity__input[name="quantity"]'),
    },
    init: () => {
        MAIN_PRODUCT_QUANTITY.onIncrease();
        MAIN_PRODUCT_QUANTITY.onDecrease();
        MAIN_PRODUCT_QUANTITY.onChange();
    },
    getValue: () => {
        return +MAIN_PRODUCT_QUANTITY.elements.input_quantity.val();
    },
    getMaxValue: () => {
        return +MAIN_PRODUCT_QUANTITY.elements.input_quantity.attr('max');
    },
    getMinValue: () => {
        return +MAIN_PRODUCT_QUANTITY.elements.input_quantity.attr('min');
    },
    setValue: (value) => {
        MAIN_PRODUCT_QUANTITY.elements.input_quantity.val(value);
    },
    onIncrease: () => {
        MAIN_PRODUCT_QUANTITY.elements.btn_increase.on('click', function() {
            const value = MAIN_PRODUCT_QUANTITY.getValue();
            const maxValue = MAIN_PRODUCT_QUANTITY.getMaxValue();

            if (value < maxValue) {
                MAIN_PRODUCT_QUANTITY.setValue(value + 1);
            }
        });
    },
    onDecrease: () => {
        MAIN_PRODUCT_QUANTITY.elements.btn_decrease.on('click', function() {
            const value = MAIN_PRODUCT_QUANTITY.getValue();
            const minValue = MAIN_PRODUCT_QUANTITY.getMinValue();

            if (value > minValue) {
                MAIN_PRODUCT_QUANTITY.setValue(value - 1);
            }
        });
    },
    onChange: () => {
        MAIN_PRODUCT_QUANTITY.elements.input_quantity.on('change', function() {
            const value = MAIN_PRODUCT_QUANTITY.getValue();
            const maxValue = MAIN_PRODUCT_QUANTITY.getMaxValue();
            const minValue = MAIN_PRODUCT_QUANTITY.getMinValue();

            if (value > maxValue) {
                toastr.warning('Số lượng vượt quá số lượng trong kho.');
                MAIN_PRODUCT_QUANTITY.setValue(maxValue);
            }

            if (value < minValue) {
                toastr.warning('Số lượng không hợp lệ.');
                MAIN_PRODUCT_QUANTITY.setValue(minValue);
            }
        });
    },
};

const PRODUCT_COMBO = {
    init: () => {
        PRODUCT_COMBO.onCheckedBuyWithCombo();
    },
    onCheckedBuyWithCombo: () => {
        $('[data-product-combo-confirm]').on('change', function() {
            $('[data-product-combo-list]').toggleClass('d-none', !$(this).is(':checked'));
        });
    },
};

PRODUCT_COMBO.init();
PRODUCT_VARIANTS.init();
PRODUCT_OPEN_IMAGE_GALERIES.init();
PRODUCT_REVIEW.init();
MAIN_PRODUCT_QUANTITY.init();
</script>
