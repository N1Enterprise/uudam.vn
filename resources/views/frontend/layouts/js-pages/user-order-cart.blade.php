<script>
    const USER_ORDER_CART = {
        authenticated_user: @json($AUTHENTICATED_USER),
        init: () => {
            USER_ORDER_CART.updateCartInfo();
        },
        updateCartInfo: () => {
            if (!USER_ORDER_CART.authenticated_user) {
                return;
            }

            $.ajax({
                url: "{{ route('fe.api.user.cart.info') }}",
                method: 'GET',
                success: (response) => {
                    $('count-items-in-cart').text(response?.total_quantity || 0);
                },
            });
        },
        addToCart: (dataOrder, callback = {}) => {
            if (!USER_ORDER_CART.authenticated_user) {
                return;
            }

            const beforeSend = callback?.beforeSend;
            const success = callback?.success;

            dataOrder = {
                user_id: USER_ORDER_CART.authenticated_user.id,
                ...dataOrder,
            };

            $.ajax({
                url: "{{ route('fe.api.user.cart.store') }}",
                method: 'POST',
                data: dataOrder,
                beforeSend: beforeSend,
                success: success,
                error: () => {},
            });
        },
    };

    USER_ORDER_CART.init();
</script>
