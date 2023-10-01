const AUTHENTICATION = {
    actions: ['signin', 'signup', 'forgot-password'],
    elements: {
        wrapper: (() => {
            return $('[data-overlay-wrapper]');
        })(),
        action_wrapper: (() => {
            return $('[data-overlay-action-wrapper]');
        })(),
        action_signin_wrapper: (() => {
            return $('[data-overlay-action-wrapper="signin"]');
        })(),
        action_signup_wrapper: (() => {
            return $('[data-overlay-action-wrapper="signup"]');
        })(),
        btn_signin: (() => {
            return $('[data-overlay-action-button="signin"]');
        })(),
        btn_signup: (() => {
            return $('[data-overlay-action-button="signup"]');
        })(),
    },
    init: () => {
        console.log(1);
        AUTHENTICATION.detectOverlay();
        AUTHENTICATION.onGoPage();
    },
    onGoPage: () => {
        $('[data-overlay-action-button]').on('click', function(e) {
            e.preventDefault();

            const overlay = $(this).attr('data-overlay-action-button');

            if (overlay && AUTHENTICATION.actions.includes(overlay)) {
                AUTHENTICATION.elements.action_wrapper.hide();

                __HELPER__.setURLParam('overlay', overlay);
                $(`[data-overlay-action-wrapper="${overlay}"]`).show();
            } else {
                AUTHENTICATION.elements.action_wrapper.hide();
                AUTHENTICATION.elements.action_wrapper.hide();
            }
        });
    },
    detectOverlay: () => {
        console.log(1);
        const overlay = __HELPER__.getURLParam('overlay');

        AUTHENTICATION.elements.wrapper.hide();
        AUTHENTICATION.elements.action_wrapper.hide();

        console.log({ overlay });

        if (overlay && AUTHENTICATION.actions.includes(overlay)) {
            AUTHENTICATION.elements.wrapper.show();
            $(`[data-overlay-action-wrapper="${overlay}"]`).show();
        }
    },
};

AUTHENTICATION.init();
