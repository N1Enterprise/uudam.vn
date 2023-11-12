<script>
    const USER_ORDER_CART = {
        init: () => {
            USER_ORDER_CART.countOrderItems();
        },
        countOrderItems: () => {
            const items = JSON.parse(__HELPER__.cookie(COOKIES_KEY.SHOPPING_CART).get() || '{}');

            const totalQuantity = Object.values(items).reduce(function(totalOrder, item) {
                return totalOrder + +(item.quantity);
            }, 0);

            $('count-items-in-cart').text(totalQuantity);
        },
    };

    USER_ORDER_CART.init();
</script>
