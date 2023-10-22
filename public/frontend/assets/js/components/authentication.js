const AUTHENTICATION = {
    actions: ['signin', 'signup', 'forgot-password'],
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
    },
    onClose: () => {
        AUTHENTICATION.elements.close.on('click', function() {
            AUTHENTICATION.elements.wrapper.hide();
            AUTHENTICATION.elements.action_wrapper.hide();

            __HELPER__.urlParams('overlay').del();
        });
    },
    onGoPage: () => {
        $('[data-overlay-action-button]').on('click', function(e) {
            e.preventDefault();

            const overlay = $(this).attr('data-overlay-action-button');

            if (overlay && AUTHENTICATION.actions.includes(overlay)) {
                AUTHENTICATION.elements.wrapper.show();
                AUTHENTICATION.elements.action_wrapper.hide();

                __HELPER__.urlParams('overlay').set(overlay);
                $(`[data-overlay-action-wrapper="${overlay}"]`).show();
            } else {
                AUTHENTICATION.elements.wrapper.hide();
                AUTHENTICATION.elements.action_wrapper.hide();
            }
        });
    },
    detectOverlay: () => {
        const overlay = __HELPER__.urlParams('overlay').get();

        AUTHENTICATION.elements.wrapper.hide();
        AUTHENTICATION.elements.action_wrapper.hide();

        if (overlay && AUTHENTICATION.actions.includes(overlay)) {
            AUTHENTICATION.elements.wrapper.show();
            $(`[data-overlay-action-wrapper="${overlay}"]`).show();
        }
    },
};

AUTHENTICATION.init();
