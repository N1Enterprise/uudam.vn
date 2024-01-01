const USER_ORDER_CART = {
    authenticated_user: (() => {
        const user = $('[data-authenticated-user]').attr('data-authenticated-user') || '{}';
        return JSON.parse(user);
    })(),
    init: () => {
        USER_ORDER_CART.updateCartInfo();
    },
    updateCartInfo: (callback = () => undefined) => {
        if (!USER_ORDER_CART.authenticated_user) {
            return;
        }

        $.ajax({
            url: CART_ROUTES.api_cart_info,
            method: 'GET',
            success: (response) => {
                $('[data-value-cart-total-quantity]').text(response?.total_quantity || 0);
                $('[data-value-cart-total-price]').text(utils_helper.formatPrice(response?.total_price || 0));

                return callback(response);
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
            url: CART_ROUTES.api_store_cart,
            method: 'POST',
            data: dataOrder,
            beforeSend: beforeSend,
            success: success,
            error: () => {},
        });
    },
};

USER_ORDER_CART.init();

export default USER_ORDER_CART;