// ==== ADDRESS_FOR_CHECKOUT LOGIC ==== //
$(() => {
    const HANDLE_CHECKOUT = {
        init: () => {
            HANDLE_CHECKOUT.getShippingRateByProviders();
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
        }
    };

    HANDLE_CHECKOUT.init();
});
