<script>
const AUTHENTICATION = {
    actions: ['signin', 'signup', 'forgot-password'],
    is_logged: "{{ !empty($AUTHENTICATED_USER) }}",
    elements: {
        close: $('[data-overlay-close]'),
        wrapper: $('[data-overlay-wrapper]'),
        action_wrapper: $('[data-overlay-action-wrapper]'),
        action_signin_wrapper: $('[data-overlay-action-wrapper="signin"]'),
        action_signup_wrapper: $('[data-overlay-action-wrapper="signup"]'),
        btn_signin: $('[data-overlay-action-button="signin"]'),
        btn_signup: $('[data-overlay-action-button="signup"]'),
    },
    init: () => {
        AUTHENTICATION.onClose();
        AUTHENTICATION.onGoPage();
        AUTHENTICATION.detectOverlay();
        AUTHENTICATION.onSignup();
        AUTHENTICATION.onSignin();
        AUTHENTICATION.onSignout();
    },
    onSignout: () => {
        $('#User_SignOut').on('click', function(e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('href'),
                method: 'POST',
                success: () => {
                    toastr.success('Đăng xuất thành công.');

                    window.location.href = "{{ route('fe.web.home') }}";
                },
            });
        });
    },
    onSignup: () => {
        $('#signup_form').on('submit', function(e) {
            e.preventDefault();

            const _self = $(this);

            const payload = {
                name: _self.find('[name="name"]').val(),
                phone_number: _self.find('[name="phone_number"]').val(),
                email: _self.find('[name="email"]').val(),
                password: _self.find('[name="password"]').val(),
            };

            $.ajax({
                url: _self.attr('action'),
                method: 'POST',
                data: payload,
                beforeSend: () => {
                    _self.find('[type="submit"]').prop('disabled', true);
                    _self.find('.form-errors').removeClass('show');
                },
                success: (response) => {
                    toastr.success('Đăng ký thành công.');

                    _self.find('[type="submit"]').prop('disabled', false);

                    AUTHENTICATION.elements.close.trigger('click');

                    window.location.href = "{{ route('fe.web.home') }}";
                },
                error: (request, status, error) => {
                    _self.find('[type="submit"]').prop('disabled', false);

                    if (request.status == 422) {
                        const errorMessage = request.responseJSON.errors;

                        utils_helper.appendErrorMessages(_self, errorMessage);
                    }
                },
            });
        });
    },
    onSignin: () => {
        $('#signin_form').on('submit', function(e) {
            e.preventDefault();

            const _self = $(this);

            const payload = {
                username: _self.find('[name="username"]').val(),
                password: _self.find('[name="password"]').val(),
            };

            $.ajax({
                url: _self.attr('action'),
                method: 'POST',
                data: payload,
                beforeSend: () => {
                    _self.find('[type="submit"]').prop('disabled', true);
                    _self.find('.form-errors').removeClass('show');
                },
                success: (response) => {
                    toastr.success('Đăng nhập thành công.');

                    _self.find('[type="submit"]').prop('disabled', false);

                    AUTHENTICATION.elements.close.trigger('click');

                    const routeRedirect = utils_helper.urlParams('redirect').get() || "{{ route('fe.web.home') }}";

                    window.location.href = routeRedirect;
                },
                error: (request, status, error) => {
                    _self.find('[type="submit"]').prop('disabled', false);

                    if (request.status == 422) {
                        const errorMessage = request.responseJSON.errors;

                        utils_helper.appendErrorMessages(_self, errorMessage);
                    }
                },
            });
        });
    },
    onClose: () => {
        AUTHENTICATION.elements.close.on('click', function() {
            AUTHENTICATION.elements.wrapper.hide();
            AUTHENTICATION.elements.action_wrapper.hide();

            utils_helper.urlParams('overlay').del();
            utils_helper.urlParams('redirect').del();
        });
    },
    onGoPage: () => {
        $('[data-overlay-action-button]').on('click', function(e) {
            e.preventDefault();

            const overlay = $(this).attr('data-overlay-action-button');
            const dataRedirect = $(this).attr('data-redirect');

            if (overlay && AUTHENTICATION.actions.includes(overlay)) {
                AUTHENTICATION.elements.wrapper.show();
                AUTHENTICATION.elements.action_wrapper.hide();

                utils_helper.urlParams('overlay').set(overlay);

                if (dataRedirect) {
                    utils_helper.urlParams('redirect').set(dataRedirect);
                }

                $(`[data-overlay-action-wrapper="${overlay}"]`).show();
            } else {
                AUTHENTICATION.elements.wrapper.hide();
                AUTHENTICATION.elements.action_wrapper.hide();
            }
        });
    },
    detectOverlay: () => {
        const overlay = utils_helper.urlParams('overlay').get();

        AUTHENTICATION.elements.wrapper.hide();
        AUTHENTICATION.elements.action_wrapper.hide();

        if (AUTHENTICATION.actions.includes(overlay) && AUTHENTICATION.is_logged) {
            utils_helper.urlParams('overlay').del();
            return;
        }

        if (overlay && AUTHENTICATION.actions.includes(overlay)) {
            AUTHENTICATION.elements.wrapper.show();
            $(`[data-overlay-action-wrapper="${overlay}"]`).show();
        }
    },
};

AUTHENTICATION.init();
</script>
