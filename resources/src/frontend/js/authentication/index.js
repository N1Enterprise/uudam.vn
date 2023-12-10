$(document).ready(function() {
    /**
     * Social Authentication
     */
    (() => {
        const SOCIAL_AUTHENTICATION = {
            init: () => {
                SOCIAL_AUTHENTICATION.onOauthLogin();
                SOCIAL_AUTHENTICATION.onDetectOauthCode();
            },
            onDetectOauthCode: () => {
                const oauthCode = utils_helper.urlParams('auth_code').get();
                const provider = utils_helper.urlParams('provider').get();

                SOCIAL_AUTHENTICATION.handleLoginWithCode(provider, oauthCode);
            },
            handleLoginWithCode: (provider, oauthCode) => {
                if (!provider || !oauthCode) {
                    return;
                }

                $.ajax({
                    url: AUTHENTICATION_ROUTES.oauth_signin,
                    method: 'POST',
                    data: { auth_code: oauthCode, provider },
                    success: (response) => {
                        window.close();
                    },
                    error: () => {
                        toastr.error('Đăng nhập không thành công.');
                    }
                });
            },
            onOauthLogin: () => {
                $('[data-oauth-provider]').on('click', function() {
                    const route = $(this).attr('data-oauth-login-route');
                    const provider = $(this).attr('data-oauth-provider');

                    const _self = $(this);

                    $.ajax({
                        url: route,
                        method: 'GET',
                        data: { provider },
                        beforeSend: () => {
                            _self.addClass('disabled');
                        },
                        success: ({ oauth_providers }) => {
                            const selectedProvider = oauth_providers.find((item) => item.provider == provider);

                            if (selectedProvider) {
                                const windowInstance = openWindow(selectedProvider?.authorization_url, 'Đăng nhập với Facebook', 600, 600);

                                var checkPopupClosed = setInterval(function () {
                                    if (windowInstance.closed) {
                                        clearInterval(checkPopupClosed);
                                        handleAfterLoginSucceed();
                                    }
                                }, 1000);

                                function handleAfterLoginSucceed() {
                                    toastr.success('Đăng nhập thành công.');

                                    setTimeout(() => window.location.reload(), 500);
                                }
                            }
                        },
                        error: () => {
                            toastr.error('Đăng nhập không thành công.');
                            _self.removeClass('disabled');
                        }
                    });
                });
            },
        };

        SOCIAL_AUTHENTICATION.init();
    })();
});
