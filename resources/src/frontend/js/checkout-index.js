$(() => {
    const HANDLE_CHECKOUT = {
        init: () => {
            HANDLE_CHECKOUT.getShippingRateByShippingOptions();
            HANDLE_CHECKOUT.onSubmit();
            HANDLE_CHECKOUT.onExpandContentShippingOption();
            HANDLE_CHECKOUT.onExpandContentPaymentOption();
            HANDLE_CHECKOUT.onBeforeLoad();

            HANDLE_CHECKOUT.initEventTrigger();
            HANDLE_CHECKOUT.onToggleSummary();
        },
        initEventTrigger: () => {
            $('[name="shipping_option_id"]:checked').trigger('change');
            $('[name="payment_option_id"]:checked').trigger('change');
        },
        onBeforeLoad: () => {

        },
        onToggleSummary: () => {
            $('.order-summary-toggle').on('click', function() {
                const isExpand = $(this).hasClass('order-summary-toggle-show');

                $(this).toggleClass('order-summary-toggle-show', !isExpand);
                $(this).toggleClass('order-summary-toggle-hide', isExpand);

                $('.order-summary').toggleClass('order-summary-is-expanded', !isExpand);
                $('.order-summary').toggleClass('order-summary-is-collapsed', isExpand);
            });
        },
        getShippingRateByShippingOptions: () => {
            const cartUuid = $('[name="checkout_cart_uuid"]').val();
            const countPaymentOptions = $('[name="shipping_option_id"]').length;
            const addressId = $('#user_address').attr('data-address-id');

            let calculated = 0;

            $('[name="shipping_option_id"]').each(function(_, element) {
                const option = $(element).val();

                $.ajax({
                    url: CHECKOUT_ROUTES.api_user_checkout_provider_shipping_free.replace(':cartUuid', cartUuid),
                    method: 'GET',
                    data: {
                        shipping_option_id: option,
                        address_id: addressId,
                    },
                    beforeSend: () => {
                        $(`[shipping-rate-value-by-option="${option}"]`).text('đang tính...');
                    },
                    success: (response) => {
                        HANDLE_CHECKOUT.calculateOrderByShippingRate(response, option);
                        HANDLE_CHECKOUT.canorder(countPaymentOptions == ++calculated);
                    },
                });
            });
        },
        canorder: (bool = false) => {
            $('[id="form-order"]').find('[type="submit"]').prop('disabled', !bool);
            $('[id="form-order"]').find('[type="submit"]').toggleClass('prevent', !bool);
            $('[id="form-order"]').find('[type="submit"] .btn-content').text(bool ? 'Đặt hàng' : 'Đang cập nhật');
        },
        calculateOrderByShippingRate: (response, shoppingOptionId) => {
            const { transport_fee_formatted, total_estimated_amount_formatted } = response;

            $(`[shipping-rate-value-by-option="${shoppingOptionId}"]`).text(transport_fee_formatted);
            $(`[name="shipping_option_id"][value="${shoppingOptionId}"]`).attr('data-fee-formatted', transport_fee_formatted);
            $(`[name="shipping_option_id"][value="${shoppingOptionId}"]`).attr('data-order-estimate-grand-total', total_estimated_amount_formatted);
            $(`[name="shipping_option_id"]:checked`).trigger('change');
        },
        onSubmit: () => {
            $('[data-form="order"]').on('submit', function(e) {
                e.preventDefault();

                const cartUuid = $('[name="checkout_cart_uuid"]').val();

                const $form = $(this);

                const route = $form.attr('action');

                const payload = {
                    shipping_option_id: $('[name="shipping_option_id"]:checked').val(),
                    payment_option_id: $('[name="payment_option_id"]:checked').val(),
                    address_id: $('#user_address').attr('data-address-id'),
                    redirect_urls: {
                        payment_success: CHECKOUT_ROUTES.web_user_checkout_with_payment_success.replace(':cart_uuid', cartUuid)
                    }
                };

                $.ajax({
                    url: route,
                    method: 'POST',
                    data: payload,
                    beforeSend: () => {
                        $form.find('[type="submit"]').prop('disabled', true);
                        $form.find('[type="submit"]').addClass('prevent');
                    },
                    success: (response) => {
                        const { payment, paying_confirmed, end_of_redirect_at } = response;

                        if (paying_confirmed) {
                            window.location.href = end_of_redirect_at;
                            return;
                        }

                        if (payment?.redirect_output) {
                            const { container } = payment.redirect_output;

                            if (container == 'redirect') {
                                return HANDLE_CHECKOUT.handlePaymentRedirect(payment.redirect_output);
                            } else if (container == 'html') {
                                return HANDLE_CHECKOUT.handlePaymentHtml(payment.redirect_output);
                            }
                        }
                    },
                });
            });
        },
        onExpandContentShippingOption: () => {
            $('[name="shipping_option_id"]').on('change', function() {
                const option = $(this).val();

                $('[data-expanded-content-shipping-option-id]').hide();
                $(`[data-expanded-content-shipping-option-id="${option}"]`).show();

                const grandTotal = $(this).attr('data-order-estimate-grand-total');
                const fee = $(this).attr('data-fee-formatted');

                $('[data-checkout-total-shipping-target]').text(fee);
                $('[data-checkout-payment-due-target]').text(grandTotal);
            });
        },
        onExpandContentPaymentOption: () => {
            $('[name="payment_option_id"]').on('change', function() {
                const option = $(this).val();

                $('[data-expanded-content-payment-option-id]').hide();
                $(`[data-expanded-content-payment-option-id="${option}"]`).show();
            });
        },
        handlePaymentRedirect: ({ url }) => {
            window.location.href = url;
        },
        handlePaymentHtml: ({ html, width, height, method }) => {

        },
    };

    HANDLE_CHECKOUT.init();
});
