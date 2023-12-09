/**
 * Social Authentication
 */
(() => {
    const SOCIAL_AUTHENTICATION = {
        init: () => {
            SOCIAL_AUTHENTICATION.onFacebookLogin();
            SOCIAL_AUTHENTICATION.onGoogleLogin();
        },
        onFacebookLogin: () => {
            console.log('facebook login');
        },
        onGoogleLogin: () => {
            console.log('google login');
        },
    };

    SOCIAL_AUTHENTICATION.init();
})();
