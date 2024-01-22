$(() => {
    const HANDLE_CHECKOUT = {
        init: () => {
            HANDLE_CHECKOUT.getShippingRateByProviders();
            HANDLE_CHECKOUT.onSubmit();
            HANDLE_CHECKOUT.onExpandContent();
            HANDLE_CHECKOUT.onBeforeLoad();

            HANDLE_CHECKOUT.initEventTrigger();
        },
        initEventTrigger: () => {
            $('[name="shipping_option"]:checked').trigger('change');
        },
        onBeforeLoad: () => {
            $(window).on('beforeunload', function(){
                
            });
        },
        getShippingRateByProviders: () => {
            const cartUuid = $('[name="checkout_cart_uuid"]').val();
            const providers = [];

            $('[name="shipping_provider"]').each(function(_, element) {
                providers.push($(element).val());
            });

            $.ajax({
                url: CHECKOUT_ROUTES.user_checkout_provider_shipping_rate.replace(':cartUuid', cartUuid),
                method: 'GET',
                data: { providers },
                beforeSend: () => {
                    $('[shipping-rate-value-by-provider]').text('đang tính...');
                },
                success: (response) => {},
            });
        },
        onSubmit: () => {
            $('[data-form="order"]').on('submit', function(e) {
                e.preventDefault();

                const $form = $(this);

                const route = $form.attr('action');

                const payload = {
                    shipping_option_id: $('[name="shipping_option_id"]:checked').val(),
                    payment_option_id: $('[name="payment_option_id"]:checked').val(),
                };

                $.ajax({
                    url: route,
                    method: 'POST',
                    data: payload,
                    beforeSend: () => {
                        $form.find('[type="submit"]').prop('disabled', true);
                        $form.find('[type="submit"]').addClass('prevent');
                    },
                    success: () => {

                    },               
                });
            });
        },
        onExpandContent: () => {
            $('[name="shipping_option"]').on('change', function() {
                const option = $(this).val();

                $('[data-expanded-content-shipping-option-id]').hide();
                $(`[data-expanded-content-shipping-option-id="${option}"]`).show();
            });
        },
    };

    HANDLE_CHECKOUT.init();
});
