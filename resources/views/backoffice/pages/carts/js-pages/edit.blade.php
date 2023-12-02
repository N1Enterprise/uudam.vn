<script>
    onChangeStatus();

    function onChangeStatus() {
        $('[data-form="change_status"]').on('submit', function(e) {
            e.preventDefault();

            const confirmation = $(this).attr('data-confirmation');
            const msgSuccess = $(this).attr('data-msg-success') || "{{ __('Change order status success.') }}";
            const msgError = $(this).attr('data-msg-error') || "{{ __('Change order status error.') }}";
            const $form = $(this);

            if (!confirmation) {
                return process();
            } else if (confirmation && confirm(confirmation)) {
                return process();
            }

            function process() {
                $.ajax({
                    url: $form.attr('action'),
                    method: $form.attr('method'),
                    data: $form.serialize(),
                    beforeSend: () => {
                        $form.find('[type="submit"]').prop('disabled', true);
                    },
                    success: () => {
                        fstoast.success(msgSuccess);

                        setTimeout(() => {
                            location.reload();
                        }, 300);
                    },
                    error: () => {
                        fstoast.error(msgError);
                        $form.find('[type="submit"]').prop('disabled', false);
                    }
                });
            }

            setTimeout(() => {
                $form.find('[type="submit"]').prop('disabled', false);
            }, 1000);
        });
    }
</script>
