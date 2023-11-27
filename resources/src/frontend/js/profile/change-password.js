$(() => {
    $('[data-form="change-password"]').validate({
        rules: {
            password: {
                required: true,
                minlength: 6,
                maxlength: 255,
            },
        },
        messages: {
            password: {
                required: 'Vui lòng nhập mật khẩu mới',
                minlength: 'Ít nhất 6 ký tự',
                maxlength: 'Không lớn hơn 255 ký tự',
            },
        },
        submitHandler: function(form) {
            const formData = $(form).serialize();
            const route = $(form).attr('action');
            const $self = $(form);

            const originalButtonText = $self.find('[data-button-submit-text]').text();

            $.ajax({
                url: route,
                method: 'POST',
                data: formData,
                beforeSend: () => {
                    $self.find('button[type="submit"]').prop('disabled', true);
                    $self.find('[data-button-submit-text]').text('Đang xử lý...');
                },
                success: (response) => {
                    toastr.success('Cập nhật thành công.');

                    window.location.reload();
                },
                error: () => {
                    $self.find('button[type="submit"]').prop('disabled', false);
                    $self.find('[data-button-submit-text]').text(originalButtonText);
                },
            });
        }
    });
});
