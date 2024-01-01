// ==== VALIDATION ==== //
$(() => {
    $('[data-form="checkout"]').validate({
        rules: {
            fullname: {
                required: true,
                minlength: 2,
                maxlength: 255,
            },
            address_line: {
                required: true,
                minlength: 2,
                maxlength: 255,
            },
            city_name: {
                required: true,
                minlength: 2,
                maxlength: 255,
            },
            phone: {
                required: true,
                minlength: 8,
                maxlength: 13,
                validate_phone: true
            }
        },
        messages: {
            fullname: {
                required: 'Vui lòng nhập họ và tên',
                maxlength: 'Không lớn hơn 255 ký tự',
                minlength: 'Tên bạn quá ngắn'
            },
            address_line: {
                required: 'Vui lòng nhập địa chỉ nhận',
                maxlength: 'Không lớn hơn 255 ký tự',
                minlength: 'Địa chỉ nhận bạn quá ngắn'
            },
            city_name: {
                required: 'Vui lòng nhập thành phố',
                maxlength: 'Không lớn hơn 255 ký tự',
                minlength: 'Tên Thành phố quá ngắn'
            },
            phone: {
                required: 'Vui lòng nhập số điện thoại',
                maxlength: 'Không lớn hơn 13 ký tự',
                minlength: 'Số điện thoại quá ngắn',
                validate_phone: "Số điện thoại không hợp lệ"
            }
        },
        submitHandler: function(form) {
            handleOrder(form);
        }
    });

    function handleOrder(form) {
        const formData = $(form).serialize();
        const route = $(form).attr('action');
        const $self = $(form);

        $.ajax({
            url: route,
            method: 'POST',
            data: formData,
            beforeSend: () => {
                $self.find('button[type="submit"]').prop('disabled', true);
                $self.find('[data-button-btn-process-order-text]').text('Đang xử lý...');
            },
            success: (response) => {
                const { paying_confirmed, end_of_redirect_at } = response;

                if (paying_confirmed) {
                    window.location.href = end_of_redirect_at?.success;
                }
            },
            error: () => {
                $self.find('button[type="submit"]').prop('disabled', false);
                $self.find('[data-button-btn-process-order-text]').text('Đặt hàng');
            },
        });
    }
});

// ==== CHECKOUT LOGIC ==== //
$(() => {
    $(document).ready(function() {
        $('[name="shipping_rate_id"]').trigger('change');
        $('[name="payment_option_id"]').trigger('change');
    })

    $('[name="shipping_rate_id"]').on('change', function() {
        calculateTransportFee();
        calculateTotalPayment();
    });

    $('[name="payment_option_id"]').on('change', function() {
        calculateTransportFee();
        calculateTotalPayment();
    });

    $('[data-form="checkout"]').on('submit', function(e) {
        e.preventDefault();
    });

    function calculateTransportFee() {
        const shippingRate = $('[name="shipping_rate_id"]:checked').attr('data-rate');

        $('[data-value-transport-fee]').text(utils_helper.formatPrice(shippingRate));
    }

    function calculateTotalPayment() {
        const totalPriceHasShipping = $('[name="shipping_rate_id"]:checked').attr('data-total-price-has-shipping');

        $('[data-value-total-payment]').text(utils_helper.formatPrice(totalPriceHasShipping));
    }
});
