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
        MAIN_INVENTORY.onHover();
        MAIN_INVENTORY.firstTrigger();
        MAIN_INVENTORY.mobileSaleActions();
    },
    mobileSaleActions: () => {
        $('[mobile-sale-action-addtocart]').on('click', function() {
            const isLogged = $('[data-canprocessasthesame]').attr('data-canprocessasthesame');
            const loginRef = $(this).attr('login-ref');

            if (!isLogged && loginRef) {
                $(loginRef).trigger('click');
                return;
            }

            FORM_ORDER.handleAddToCart(() => {
                fstoast.success('Đã thêm sản phẩm vào giỏ?', '', {
                    onclick: () => {
                        window.location.href = $('#cart-icon-bubble').attr('href');
                    },
                });
            });
        });

        $('[mobile-sale-action-buynow]').on('click', function() {
            $('#buy_now').trigger('click');
        });
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
    onHover: () => {
        $('.attributes-values-item .label').hover(function(e) {
            // const inventory = MAIN_INVENTORY.findInventory($(this));

            // const orinImage = $('.product__media-item.is-active').attr('original-image');
            // const newImage  = inventory.image;

            // console.log({
            //     orinImage,
            //     newImage
            // });

            // const imageElement = $('.owl-item.active .product__media-item.is-active').find('img');

            // const type = e.type;

            // if (type == 'mouseover') {
            //     imageElement.attr('src', newImage);
            //     imageElement.attr('srcset', newImage);
            // } else if (type == 'mouseout') {
            //     imageElement.attr('src', orinImage);
            //     imageElement.attr('srcset', orinImage);
            // }
        });
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
    findInventory: (element) => {
        const conditions = {};

        conditions[ + ($(element).find('input').attr('data-attribute-id')) ] = + ($(element).find('input').val());

        const inventory = MAIN_INVENTORY.variant_resources.find(function(item) {
            const attributes = item.attributes.map((item) => item.id);
            const attrValues = item.attribute_values.map((item) => item.id);

            const matches = (() => {
                if (
                    // Object.keys(conditions).length == attributes.length
                    Object.keys(conditions).every((id) => attributes.includes(+id))
                ) {
                    if (
                        // Object.values(conditions).length == attrValues.length
                        Object.values(conditions).every((id) => attrValues.includes(+id))
                    ) {
                        return true;
                    }
                }

                return false;
            })();

            return matches;
        });

        return inventory;
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

        $('html, body').animate({ scrollTop : 0 }, 800, function() {
            window.location.href = href;
        });
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
            $('.product-modal-media .product-media-modal').attr('open', 'true');
            $('body').addClass('full-mode');
        });
    },
    onClose: () => {
        MAIN_INVENTORY_OPEN_IMAGE_GALERIES.close_element.on('click', function() {
            $('.product-modal-media .product-media-modal').removeAttr('open');
            $('body').removeClass('full-mode');
            MAIN_INVENTORY_OPEN_IMAGE_GALERIES.video_iframe.remove();
            setTimeout(() => { $('.product-modal-media .product-media-modal__video').html(MAIN_INVENTORY_OPEN_IMAGE_GALERIES.video_iframe) }, 100);
        });
    },
};

const MAIN_INVENTORY_OPEN_DESCRIPTION = {
    close_element: $('[data-description-modal-close]'),
    open_element: $('[data-description-modal-open]'),
    init: () => {
        MAIN_INVENTORY_OPEN_DESCRIPTION.onOpen();
        MAIN_INVENTORY_OPEN_DESCRIPTION.onClose();
    },
    onOpen: () => {
        MAIN_INVENTORY_OPEN_DESCRIPTION.open_element.on('click', function() {
            $('.product-modal-description .product-media-modal').attr('open', 'true');
            $('body').addClass('full-mode');
        });
    },
    onClose: () => {
        MAIN_INVENTORY_OPEN_DESCRIPTION.close_element.on('click', function() {
            $('.product-modal-description .product-media-modal').removeAttr('open');
            $('body').removeClass('full-mode');
        });
    },
};

const MAIN_INVENTORY_OPEN_PRODUCT_REVIEW = {
    close_element: $('[data-product-review-modal-close]'),
    open_element: $('[data-product-review-modal-open]'),
    init: () => {
        MAIN_INVENTORY_OPEN_PRODUCT_REVIEW.onOpen();
        MAIN_INVENTORY_OPEN_PRODUCT_REVIEW.onClose();
    },
    onOpen: () => {
        MAIN_INVENTORY_OPEN_PRODUCT_REVIEW.open_element.on('click', function() {
            $('.product-modal-product-review .product-media-modal').attr('open', 'true');
            $('body').addClass('full-mode');
        });
    },
    onClose: () => {
        MAIN_INVENTORY_OPEN_PRODUCT_REVIEW.close_element.on('click', function() {
            $('.product-modal-product-review .product-media-modal').removeAttr('open');
            $('body').removeClass('full-mode');
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

            const button = $('#User_Product_Review').find('button[type="submit"]');
            const ratingName = $('[name="rating_type"]').find(`option[value="${$('[name="rating_type"]').val()}"]`).text();

            var formData = new FormData();

            const productId = $(this).find('[name="product_id"]').val();
            const ratingType = $(this).find('[name="rating_type"]').val();
            const content = $(this).find('[name="content"]').val();

            console.log({
                productId,
                ratingType,
                content
            });

            formData.append('product_id', productId);
            formData.append('rating_type', ratingType);
            formData.append('content', content);

            var files = $('#review_files')[0].files;

            // Append each file to the FormData object
            $.each(files, function(index, file) {
                formData.append('images[][file]', file);
            });

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
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
        FORM_ORDER.onBuyNow();
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
    /**
     * product-sale-btn-item product-sale-btn-add-to-cart product-form__submit button button--full-width button--primary
     */
    onBuyNow: () => {
        $('#buy_now').on('click', function() {
            const returnUrl = $(this).attr('data-return-url');

            const isLogged = $('[data-canprocessasthesame]').attr('data-canprocessasthesame');
            const loginRef = $(this).attr('login-ref');

            if (!isLogged && loginRef) {
                $(loginRef).trigger('click');
                return;
            }

            FORM_ORDER.handleAddToCart(() => {
                window.location.href = returnUrl;
            });
        });
    },
    onAddToCart: () => {
        $('form[form-add-to-cart]').on('submit', function(e) {
            e.preventDefault();

            const isLogged = $('[data-canprocessasthesame]').attr('data-canprocessasthesame');
            const loginRef = $(this).attr('login-ref');

            if (!isLogged && loginRef) {
                $(loginRef).trigger('click');
                return;
            }

            FORM_ORDER.handleAddToCart(() => {
                fstoast.success('Đã thêm sản phẩm vào giỏ?', '', {
                    onclick: () => {
                        window.location.href = $('#cart-icon-bubble').attr('href');
                    },
                });
            });
        });
    },
    handleAddToCart: (callback = () => undefined) => {
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

                return callback();
            },
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
MAIN_INVENTORY_OPEN_DESCRIPTION.init();
MAIN_INVENTORY_OPEN_PRODUCT_REVIEW.init();
MAIN_INVENTORY_REVIEW.init();
MAIN_INVENTORY_QUANTITY.init();
FORM_ORDER.init();


$(document).ready(function() {
    $('.review-inputfile').change(function() {
        var input = this;
        var label = $(input).next('label');
        var labelVal = label.html();

        // Check if the number of selected files exceeds 3
        if (input.files && input.files.length > 3) {
            alert("Bạn chỉ có thể thêm tối đa 3 ảnh.");
            // Clear the file input
            $(input).val('');
            label.html(labelVal);
            return; // Exit the function
        }

        var fileName = '';
        if (input.files && input.files.length > 1) {
            fileName = ($(input).data('multiple-caption') || '').replace('{count}', input.files.length);
        } else {
            fileName = $(input).val().split('\\').pop();
        }

        if (fileName) {
            label.find('span').html(fileName);
        } else {
            label.html(labelVal);
        }
    });
});

$(document).ready(function() {
    $(window).on('scroll', function() {
        const scrollPosition = $(window).scrollTop();
        const targetOffsetTop = $('.product-form__buttons').offset().top;
        const targetOffsetHei = $('.product-form__buttons').outerHeight();

        if ((scrollPosition + targetOffsetHei) > targetOffsetTop) {
            $('.mobile-sale-actions').addClass('show');
        } else {
            $('.mobile-sale-actions').removeClass('show');
        }
    });
});
