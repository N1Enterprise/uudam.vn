$(document).ready(function() {
    $('#modal-cancel-order').find('[data-overlay-close]').on('click', function() {
        $('#modal-cancel-order').removeAttr('open');
    });

    $('#btn-cancel-order').on('click', function() {
        $('#modal-cancel-order').attr('open', true);
    });

    $('#cancel_order_form').find('[name="reason"]').on('change', function() {
        handleCancelOrder();
    });

    $('#cancel_order_form').find('[name="content"]').on('input', function() {
        handleCancelOrder();
    });

    function handleCancelOrder() {
        const reason  = $('#cancel_order_form').find('[name="reason"]').val();
        const content = $('#cancel_order_form').find('[name="content"]').val();

        const isValid = !!(reason.trim()).length && !!(content.trim()).length;

        $('#cancel_order_form').find('[type="submit"]').prop('disabled', !isValid);
    }

    $('#cancel_order_form').on('submit', function(e) {
        e.preventDefault();

        const reason  = $('#cancel_order_form').find('[name="reason"]').val();
        const content = $('#cancel_order_form').find('[name="content"]').val();

        const _self = $(this);

        $.ajax({
            url: _self.attr('action'),
            method: 'POST',
            data: {reason, content},
            beforeSend: () => {
                _self.find('[type="submit"]').prop('disabled', true);
            },
            success: () => {
                toastr.success('Huỷ đơn hàng thành công.');
                _self.find('[type="submit"]').prop('disabled', false);

                setTimeout(() => {
                    window.location.reload();
                }, 500);
            },
            error: () => {
                _self.find('[type="submit"]').prop('disabled', false);
                toastr.error('Huỷ đơn hàng không thành công.');
            },
        });
    });
});
