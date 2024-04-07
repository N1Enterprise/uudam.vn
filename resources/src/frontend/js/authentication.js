$(document).ready(function() {
    /**
     * Social Authentication
     */
    (() => {
        const SOCIAL_AUTHENTICATION = {
            init: () => {
                SOCIAL_AUTHENTICATION.onOauthLogin();
                SOCIAL_AUTHENTICATION.onDetectOauthCode();
                SOCIAL_AUTHENTICATION.onContinuteLoginWhenComplete();
            },
            onDetectOauthCode: () => {
                const oauthCode = utils_helper.urlParams('auth_code').get();
                const provider = utils_helper.urlParams('provider').get();

                SOCIAL_AUTHENTICATION.handleLoginWithCode(provider, oauthCode);
            },
            onContinuteLoginWhenComplete: () => {
                $('#required_oauth_user_complete_information_before_signin').on('submit', function(e) {
                    e.preventDefault();

                    const oauthCode = utils_helper.urlParams('auth_code').get();
                    const provider = utils_helper.urlParams('provider').get();
                    const phoneNumber = $(this).find('[name="phone_number"]').val();

                    const regex = /(84|0[35789])+([0-9]{8})\b/;

                    if (! (regex.test(phoneNumber))) {
                        utils_helper.appendErrorMessages($(this), { 'phone_number': ['Số điện thoại không hợp lệ'] });
                        return;
                    }

                    $(this).find('.form-errors').removeClass('show');

                    SOCIAL_AUTHENTICATION.handleLoginWithCode(provider, oauthCode, true, { 'phone_number': phoneNumber }, $(this));
                });
            },
            handleLoginWithCode: (provider, oauthCode, ignoreCheckRequiredComplete = false, data = [], $form = null) => {
                if (!provider || !oauthCode) {
                    return;
                }

                const requiredOauthUserCompleteInformationBeforeSignin = $('[required_oauth_user_complete_information_before_signin]');

                if (requiredOauthUserCompleteInformationBeforeSignin.length && !ignoreCheckRequiredComplete) {
                    setTimeout(() => {
                        $('[data-overlay-wrapper]').show();
                        requiredOauthUserCompleteInformationBeforeSignin.show();
                    }, 500);

                    return;
                }

                $.ajax({
                    url: AUTHENTICATION_ROUTES.api_oauth_signin,
                    method: 'POST',
                    data: { auth_code: oauthCode, provider, ...data },
                    success: (response) => {
                        toastr.success('Đăng nhập thành công.');

                        setTimeout(() => {
                            window.opener
                                ? window.close()
                                : window.location.href = Cookies.get(COOKIE_KEYS.CURRENT_URL);
                        }, 500);
                    },
                    error: (request) => {
                        toastr.error('Đăng nhập không thành công.');

                        // utils_helper.urlParams('auth_code').del();
                        // utils_helper.urlParams('provider').del();

                        if (request.status == 422 && $form) {
                            const errorMessage = request.responseJSON.errors;

                            utils_helper.appendErrorMessages($form, errorMessage);
                        }
                    }
                });
            },
            loginWithWindowPopup: (provider) => {
                const windowInstance = openWindow(provider?.authorization_url, 'Đăng nhập với Facebook', 600, 600);

                if (! windowInstance) {
                    return SOCIAL_AUTHENTICATION.loginWithNewTab(provider);
                }

                var checkPopupClosed = setInterval(function () {
                    if (windowInstance.closed) {
                        clearInterval(checkPopupClosed);
                        handleAfterLoginSucceed();
                    }
                }, 1000);

                function handleAfterLoginSucceed() {
                    setTimeout(() => window.location.reload(), 500);
                }
            },
            loginWithNewTab: (provider) => {
                window.location.href = provider?.authorization_url;
            },
            onOauthLogin: () => {
                $('[data-oauth-provider]').on('click', function() {
                    const route = $(this).attr('data-oauth-login-route');
                    const provider = $(this).attr('data-oauth-provider');

                    $.ajax({
                        url: route,
                        method: 'GET',
                        data: { provider },
                        beforeSend: () => {
                            // $('[data-oauth-provider]').addClass('disabled');
                        },
                        success: ({ oauth_providers }) => {
                            const selectedProvider = oauth_providers.find((item) => item.provider == provider);

                            if (selectedProvider) {
                                const windowWidth = window.innerWidth;

                                Cookies.set(COOKIE_KEYS.CURRENT_URL, window.location.href);

                                if (windowWidth > 800) {
                                    return SOCIAL_AUTHENTICATION.loginWithWindowPopup(selectedProvider);
                                }

                                return SOCIAL_AUTHENTICATION.loginWithNewTab(selectedProvider);
                            }
                        },
                        error: () => {
                            toastr.error('Đăng nhập không thành công.');

                            utils_helper.urlParams('auth_code').del();
                            utils_helper.urlParams('provider').del();

                            $('[data-oauth-provider]').removeClass('disabled');
                        }
                    });
                });
            },
        };

        SOCIAL_AUTHENTICATION.init();
    })();

    (() => {
        const AUTHENTICATION = {
            actions: ['signin', 'signup', 'forgot-password', 'reset-password'],
            is_logged: $('[data-canprocessasthesame]').attr('data-canprocessasthesame'),
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
                AUTHENTICATION.onForgetPassword();
                AUTHENTICATION.onChangePassword();
            },
            onChangePassword: () => {
                $('#reset_password_form').on('submit', function(e) {
                    e.preventDefault();

                    const _self = $(this);

                    $.ajax({
                        url: _self.attr('action'),
                        method: 'PUT',
                        data: _self.serialize(),
                        beforeSend: () => {
                            _self.find('[type="submit"]').prop('disabled', true);
                            _self.find('[type="submit"]').text('Đang xử lí...');
                        },
                        success: () => {
                            toastr.success('Thay đổi mật khẩu thành công.');

                            _self.find('[data-overlay-action-button="signin"]').trigger('click');
                        },
                        error: (request, status, error) => {
                            _self.find('[type="submit"]').prop('disabled', false);
                            _self.find('[type="submit"]').text('Xác nhận thay đổi');

                            toastr.error('Thay đổi mật khẩu không thành công.');

                            if (request.status == 422) {
                                const errorMessage = request.responseJSON.errors;

                                utils_helper.appendErrorMessages(_self, errorMessage);
                            }
                        },
                    });
                });
            },
            onForgetPassword: () => {
                $('#forgot_password_form').on('submit', function(e) {
                    e.preventDefault();

                    const _self = $(this);

                    const payload = {
                        email: _self.find('[name="email"]').val(),
                    };

                    $.ajax({
                        url: _self.attr('action'),
                        method: 'POST',
                        data: payload,
                        beforeSend: () => {
                            _self.find('[type="submit"]').prop('disabled', true);
                            _self.find('.form-errors').removeClass('show');

                            $('.password-reset-sent-success').addClass('d-none');
                            $('.password-reset-pending').removeClass('d-none');
                        },
                        success: (response) => {
                            $('.password-reset-sent-success').find('user-mail').text(payload.email);

                            $('.password-reset-sent-success').removeClass('d-none');
                            $('.password-reset-pending').addClass('d-none');

                            utils_helper.urlParams('overlay').del();
                            utils_helper.urlParams('redirect').del();
                        },
                        error: (request, status, error) => {
                            _self.find('[type="submit"]').prop('disabled', false);
                            toastr.error('Xử lí quên mật khẩu không thành công.');

                            if (request.status == 422) {
                                const errorMessage = request.responseJSON.errors;

                                utils_helper.appendErrorMessages(_self, errorMessage);
                            }
                        },
                    });
                });
            },
            onSignout: () => {
                $('#User_SignOut').on('click', function(e) {
                    e.preventDefault();

                    $.ajax({
                        url: $(this).attr('href'),
                        method: 'POST',
                        success: () => {
                            toastr.success('Đăng xuất thành công.');

                            window.location.href = HOME_ROUTES.web_home;
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

                            window.location.href = HOME_ROUTES.web_home;
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

                            const routeRedirect = utils_helper.urlParams('redirect').get() || HOME_ROUTES.web_home;

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
                    utils_helper.urlParams('token').del();
                    utils_helper.urlParams('email').del();

                    $('.password-reset-sent-success').addClass('d-none');
                    $('.password-reset-pending').removeClass('d-none');
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
                    const redirect = utils_helper.urlParams('redirect').get();

                    utils_helper.urlParams('overlay').del();

                    if (redirect) {
                        window.location.href = redirect;
                    }

                    return;
                }

                if (overlay && AUTHENTICATION.actions.includes(overlay)) {
                    AUTHENTICATION.elements.wrapper.show();
                    $(`[data-overlay-action-wrapper="${overlay}"]`).show();
                }
            },
        };

        AUTHENTICATION.init();
    })();
});
