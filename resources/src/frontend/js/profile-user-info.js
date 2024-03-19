$(() => {
    $('[data-form="user-info"]').validate({
        rules: {
            name: {
                required: true,
                maxlength: 20,
            },
            email: {
                required: false,
                maxlength: 255,
                validate_email: true,
            },
            phone_number: {
                required: true,
                maxlength: 15,
                validate_phone: true
            },
        },
        messages: {
            name: {
                required: 'Vui lòng nhập họ và tên',
                maxlength: 'Không lớn hơn 25 ký tự',
            },
            email: {
                required: 'Vui lòng nhập e-mail',
                maxlength: 'Không lớn hơn 255 ký tự',
                validate_email: "E-mail không hợp lệ"
            },
            phone_number: {
                required: 'Vui lòng nhập số điện thoại',
                maxlength: 'Không lớn hơn 15 ký tự',
                validate_phone: "Số điện thoại không hợp lệ"
            }
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

                    setTimeout(() => window.location.reload(), 500);
                },
                error: () => {
                    $self.find('button[type="submit"]').prop('disabled', false);
                    $self.find('[data-button-submit-text]').text(originalButtonText);
                },
            });
        }
    });
});
