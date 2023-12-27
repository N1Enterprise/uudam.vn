import USER_ORDER_CART from './user-order-cart';

const MY_CART = {
    init: () => {
        MY_CART.onRemove();
        MY_CART.onQuantity();
    },
    onQuantity: () => {
        $.each($('quantity-input.quantity'), function(index, element) {
            const cartID = $(element).attr('data-cart-id');
            const quantityID = `cart_item_${cartID}`;
            const $cartItem = $(element).parents('tr');

            utils_quantity(quantityID, {
                callbacks: {
                    onChange: (value) => {
                        utils_helper.debounce(process, 1000)();

                        function process() {
                            MY_CART.updateCartItemQuantity(cartID, value, ({ price, total_price }) => {
                                $cartItem.find('[data-value-cart-item-price]').text(utils_helper.formatPrice(price));
                                $cartItem.find('[data-value-cart-item-total-price]').text(utils_helper.formatPrice(total_price));
                                USER_ORDER_CART.updateCartInfo();
                            });
                        }
                    }
                }
            });
        });
    },
    updateCartItemQuantity: (id, quantity, callback = () => undefined) => {
        $.ajax({
            url: CART_ROUTES.api_update_quantity.replace(':id', id),
            method: 'PUT',
            data: { quantity },
            beforeSend: () => {},
            success: (response) => {
                return callback(response);
            },
        });
    },
    onRemove: () => {
        $('[cart-remove-button]').on('click', function() {

            const cartId = $(this).attr('data-cart-id');

            utils_helper.swal({
                title: 'Xoá sản phẩm',
                html: 'Bạn có muốn xoá sản phẩm đang chọn',
                showConfirmButton: 1
            }).then(async ({ value }) => {
                if (! value) return;

                const $self = $(this);

                $.ajax({
                    url: CART_ROUTES.api_delete.replace(':id', cartId),
                    method: 'PUT',
                    beforeSend: () => {
                        $self.addClass('prevent');
                        $self.text('đang xoá...');
                    },
                    success: () => {
                        $self.parents('tr.cart-item').remove();
                        $self.parents('');

                        USER_ORDER_CART.updateCartInfo((data) => {
                            if (data?.total_items || 0 == 0) {
                                utils_helper.reload();
                            }
                        });
                    },
                    error: () => {
                        $self.removeClass('prevent');
                    },
                });
            });
        });
    },
};

MY_CART.init();