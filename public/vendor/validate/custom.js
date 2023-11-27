(function($) {
    $(function() {
        // =========================================
        // Add Global setup default
        // =========================================
        $.validator.setDefaults({
            errorClass: "msg-error",
            validClass: "focus",
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $('.invalid-feedback.server').remove();
                $(element).addClass('input is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
        });

        // =========================================
        // Add Global validate method
        // =========================================

        // Validate Email valid
        $.validator.addMethod('validate_email', function(value, element) {
            if (value.match(/^[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]*)*@[a-zA-Z]+([a-zA-Z0-9]*(_|-|\.){0,1}[a-zA-Z0-9])+(\.[a-z]{2,4})$/)) {
                return true;
            }

            return false;
        }, $.validator.format("Please enter the correct value"));

        // Validate Password valid
        $.validator.addMethod('validate_password', function(value, element) {
            if (value.match(/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/)) {
                return true;
            }

            return false;
        }, $.validator.format("Please enter the correct value"));

        // Validate Username valid
        $.validator.addMethod('validate_username', function(value, element) {
            if (/^[a-z0-9_\.]+$/.test(value)) {
                return true;
            }

            return false;
        }, $.validator.format("Please enter the correct value"));

        // Validate Phone valid
        $.validator.addMethod('validate_phone', function(value, element) {
            const regex = /(84|0[35789])+([0-9]{8})\b/;

            return regex.test(value);
        }, $.validator.format("Please enter the correct value"));
    });
})(jQuery);
