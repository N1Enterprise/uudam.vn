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
                        toastr.success('Đăng nhập thành công.');

                        if (window.opener) {
                            setTimeout(() => window.close(), 500);
                        } else {
                            window.location.href = Cookies.get(COOKIE_KEYS.CURRENT_URL);
                        }
                    },
                    error: () => {
                        toastr.error('Đăng nhập không thành công.');
                    }
                });
            },
            loginWithWindowPopup: (provider) => {
                const windowInstance = openWindow(provider?.authorization_url, 'Đăng nhập với Facebook', 600, 600);

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
                            $('[data-oauth-provider]').addClass('disabled');
                        },
                        success: ({ oauth_providers }) => {
                            const selectedProvider = oauth_providers.find((item) => item.provider == provider);

                            if (selectedProvider) {
                                const windowWidth = window.innerWidth;

                                Cookies.set(COOKIE_KEYS.CURRENT_URL, window.location.href);

                                if (windowWidth <= 800) {
                                    return SOCIAL_AUTHENTICATION.loginWithNewTab(selectedProvider);
                                } else {
                                    return SOCIAL_AUTHENTICATION.loginWithWindowPopup(selectedProvider);
                                }
                            }
                        },
                        error: () => {
                            toastr.error('Đăng nhập không thành công.');
                            $('[data-oauth-provider]').removeClass('disabled');
                        }
                    });
                });
            },
        };

        SOCIAL_AUTHENTICATION.init();
    })();
});
