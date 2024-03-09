import USER_ORDER_CART from './user-order-cart';

$('.thumbnail-list__item').on('click', function() {
    const index = $(this).attr('data-owl-index');

    $('[data-owl-id="Slider_Product_Detail"]').trigger('to.owl.carousel', index);

    $('.thumbnail-list__item').find('button.thumbnail').removeAttr('aria-current');
    $(this).find('button.thumbnail').attr('aria-current', 'true');
});

$('.share-button__copy').on('click', function() {
    const text = $('#url.field__input').val();

    utils_helper.copyClipBoard(text);
});

const MAIN_INVENTORY = {
    init: () => {
        MAIN_INVENTORY.onChange();
        MAIN_INVENTORY.firstTrigger();
    },
    variant_resources: (() => {
        const data = $('#inventory_variants').attr('data-variants') || '{}';

        return JSON.parse(data);
    })(),
    inventory_selected: (() => {
        const data = JSON.parse($('[data-inventory]').attr('data-inventory') || '{}');

        return data;
    })(),
    inventory_combos: [],
    firstTrigger: () => {
        FORM_ORDER.setDataOrder();
    },
    getFullData: () => {
        const data = {
            product_id: $('[name="product_id"]').val(),
            inventory: MAIN_INVENTORY.inventory_selected,
            has_combo: $('[data-product-combo-confirm]').is(':checked'),
            quantity: $('[data-stock-quantity]').val() || 0
        };

        return data;
    },
    calculateInventoryPrice: () => {
        const hasCombo = $('[data-product-combo-confirm]').is(':checked');
        const label = hasCombo ? 'Tổng Combo' : 'Tạm tính';
        const inventoryPrice = $('[data-price-value]').attr('data-price-value') || 0;
        const stockQuantity = $('[data-stock-quantity]').val() || 0;

        const totalPriceByStockQuantity = utils_helper.number(inventoryPrice).multiply(stockQuantity);

        const totalCartPrice = hasCombo ? (() => {
            // Has Combo
            return MAIN_INVENTORY.inventory_combos.reduce(function(accumulator, currentValue) {
                return accumulator + utils_helper.number(currentValue?.sale_price || 0).toFloat();
            }, totalPriceByStockQuantity);
        })() : (() => {
            // No Combo
            return totalPriceByStockQuantity;
        })();

        $('[data-total-cart-label]').text(label);
        $('[data-total-cart-price]').html(utils_helper.formatPrice(totalCartPrice));
    },
    onChange: () => {
        $('[name="attribute_value"]').on('change', function() {
            const value = $(this).val();
            const parent = $(this).parents('.attributes-item');

            parent.find('[name="attribute_value"]').prop('checked', false);
            parent.find('[name="attribute_value"]').parents('.label').removeClass('active');

            $(this).prop('checked', true);
            $(this).parents('.label').addClass('active');

            MAIN_INVENTORY.findProductByAttribute();

            MAIN_INVENTORY.calculateInventoryPrice();
            // MAIN_INVENTORY_QUANTITY.setValue(1);
            FORM_ORDER.setDataOrder();

            $('[data-stock-quantity]').trigger('change');
        });
    },
    findProductByAttribute: () => {
        const conditions = {};

        $.each($('.label.active'), function(index, element) {
            conditions[ + ($(element).find('input').attr('data-attribute-id')) ] = + ($(element).find('input').val());
        });

        const inventory = MAIN_INVENTORY.variant_resources.find(function(item) {
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

        MAIN_INVENTORY.renderInventory(inventory || null);
        MAIN_INVENTORY.inventory_selected = inventory || null;
        MAIN_INVENTORY.inventory_combos = inventory?.product_combos || [];
    },
    renderInventory: (inventory) => {
        const href = PRODUCT_ROUTES.web_detail.replace(':slug', inventory.slug);

        window.location.href = href;
    },
};

const MAIN_INVENTORY_OPEN_IMAGE_GALERIES = {
    close_element: $('[data-media-modal-close]'),
    open_element: $('[data-media-modal-open]'),
    video_iframe: $('#product-video-iframe'),
    init: () => {
        MAIN_INVENTORY_OPEN_IMAGE_GALERIES.onOpen();
        MAIN_INVENTORY_OPEN_IMAGE_GALERIES.onClose();
    },
    onOpen: () => {
        MAIN_INVENTORY_OPEN_IMAGE_GALERIES.open_element.on('click', function() {
            $('.product-media-modal').attr('open', 'true');
        });
    },
    onClose: () => {
        MAIN_INVENTORY_OPEN_IMAGE_GALERIES.close_element.on('click', function() {
            $('.product-media-modal').removeAttr('open');
            MAIN_INVENTORY_OPEN_IMAGE_GALERIES.video_iframe.remove();
            setTimeout(() => { $('.product-media-modal__video').html(MAIN_INVENTORY_OPEN_IMAGE_GALERIES.video_iframe) }, 100);
        });
    },
};

const MAIN_INVENTORY_REVIEW = {
    init: () => {
        MAIN_INVENTORY_REVIEW.onToggle();
        MAIN_INVENTORY_REVIEW.onReview();
    },
    onToggle: () => {
        $('.spr-summary-actions-newreview').on('click', function() {
            $('[data-product-review]').toggleClass('d-none');
        });
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

                    MAIN_INVENTORY_REVIEW.makeReviewHTML(response);
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

const COMBO_INVENTORY = {
    init: () => {
        COMBO_INVENTORY.onCheckedBuyWithCombo();
    },
    onCheckedBuyWithCombo: () => {
        $('[data-product-combo-confirm]').on('change', function() {
            MAIN_INVENTORY.calculateInventoryPrice();
            FORM_ORDER.setDataOrder();

            $('[data-stock-quantity]').trigger('change');
        });
    },
    recalculatePrice: (productQuantity) => {
        const { product_combos } = MAIN_INVENTORY.inventory_selected;

        const newProductCombos = [...product_combos].map(function(item) {
            return {
                ...item,
                sale_price: utils_helper.number(item.sale_price).multiply(productQuantity)
            };
        });

        MAIN_INVENTORY.inventory_combos = newProductCombos;
    },
};

const FORM_ORDER = {
    init: () => {
        FORM_ORDER.onAddToCart();
    },
    formOrderData: {},
    updateCookie: (data) => {
        utils_helper.cookie(COOKIES_KEY.SHOPPING_CART).set(JSON.stringify(data));
    },
    setDataOrder: () => {
        const { quantity, has_combo, inventory, product_id } = MAIN_INVENTORY.getFullData();

        $('form[form-add-to-cart]').find('[name="product_id"]').val(product_id);
        $('form[form-add-to-cart]').find('[name="inventory_id"]').val(inventory.id);
        $('form[form-add-to-cart]').find('[name="has_combo"]').val(has_combo ? '1' : '0');
        $('form[form-add-to-cart]').find('[name="quantity"]').val(quantity);

        FORM_ORDER.formOrderData = {
            product_id: +product_id,
            inventory_id: inventory.id,
            has_combo: has_combo ? 1 : 0,
            quantity: +quantity
        };
    },
    onAddToCart: () => {
        $('form[form-add-to-cart]').on('submit', function(e) {
            e.preventDefault();

            const isLogged = $('[data-canprocessasthesame]').attr('data-canprocessasthesame');
            const loginRef = $(this).attr('login-ref');

            if (!isLogged && loginRef) {
                $(loginRef).trigger('click');
            }

            USER_ORDER_CART.addToCart({
                ...FORM_ORDER.formOrderData
            }, {
                beforeSend: () => {
                    $('form[form-add-to-cart]').find('button[type="submit"]').addClass('loading');
                    $('form[form-add-to-cart]').find('.loading-overlay__spinner').removeClass('hidden');
                },
                success: (response) => {
                    $('form[form-add-to-cart]').find('button[type="submit"]').removeClass('loading');
                    $('form[form-add-to-cart]').find('.loading-overlay__spinner').addClass('hidden');
                    
                    USER_ORDER_CART.updateCartInfo();

                    fstoast.success('Đã thêm sản phẩm vào giỏ?', '', {
                        onclick: () => {
                            window.location.href = $('#cart-icon-bubble').attr('href');
                        },
                    });
                },
            });
        });
    },
};

const MAIN_INVENTORY_QUANTITY = {
    init: () => {
        utils_quantity('product', {
            callbacks: {
                onChange: (value) => {
                    COMBO_INVENTORY.recalculatePrice(value);
                    MAIN_INVENTORY.calculateInventoryPrice();
                    FORM_ORDER.setDataOrder();
                }
            }
        });
    },
};

COMBO_INVENTORY.init();
MAIN_INVENTORY.init();
MAIN_INVENTORY_OPEN_IMAGE_GALERIES.init();
MAIN_INVENTORY_REVIEW.init();
MAIN_INVENTORY_QUANTITY.init();
FORM_ORDER.init();