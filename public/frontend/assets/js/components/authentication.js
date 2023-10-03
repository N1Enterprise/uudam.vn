const AUTHENTICATION_OVERLAY = {
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
        AUTHENTICATION_OVERLAY.onClose();
        AUTHENTICATION_OVERLAY.onGoPage();
        AUTHENTICATION_OVERLAY.detectOverlay();
    },
    onClose: () => {
        AUTHENTICATION_OVERLAY.elements.close.on('click', function() {
            AUTHENTICATION_OVERLAY.elements.wrapper.hide();
            AUTHENTICATION_OVERLAY.elements.action_wrapper.hide();

            __HELPER__.urlParams('overlay').del();
        });
    },
    onGoPage: () => {
        $('[data-overlay-action-button]').on('click', function(e) {
            e.preventDefault();

            const overlay = $(this).attr('data-overlay-action-button');

            if (overlay && AUTHENTICATION_OVERLAY.actions.includes(overlay)) {
                AUTHENTICATION_OVERLAY.elements.wrapper.show();
                AUTHENTICATION_OVERLAY.elements.action_wrapper.hide();

                __HELPER__.urlParams('overlay').set(overlay);
                $(`[data-overlay-action-wrapper="${overlay}"]`).show();
            } else {
                AUTHENTICATION_OVERLAY.elements.wrapper.hide();
                AUTHENTICATION_OVERLAY.elements.action_wrapper.hide();
            }
        });
    },
    detectOverlay: () => {
        const overlay = __HELPER__.urlParams('overlay').get();

        AUTHENTICATION_OVERLAY.elements.wrapper.hide();
        AUTHENTICATION_OVERLAY.elements.action_wrapper.hide();

        if (overlay && AUTHENTICATION_OVERLAY.actions.includes(overlay)) {
            AUTHENTICATION_OVERLAY.elements.wrapper.show();
            $(`[data-overlay-action-wrapper="${overlay}"]`).show();
        }
    },
};

const AUTHENTICATION_HANDLER = {
    init: () => {
        AUTHENTICATION_HANDLER.onSignin();
        AUTHENTICATION_HANDLER.onSignup();
        AUTHENTICATION_HANDLER.onForgotPassword();
    },
    onSignin: () => {
        $('#signin_form').on('submit', function(e) {
            e.preventDefault();

            const formValues = $(this).serialize();
            const route = $(this).attr('action');
            const button = $(this).find('button[type="submit"]');

            $.ajax({
                url: route,
                method: 'POST',
                data: formValues,
                beforeSend: () => {
                    __HELPER__.element(button).disable();
                },
                success: (response) => {
                    __HELPER__.toast().success("Đăng nhập thành công!");
                    __HELPER__.urlParams('overlay').del();

                    setTimeout(() => window.location.reload(), 500);
                },
                error: () => {
                    __HELPER__.toast().error("Đăng nhập không thành công!");
                },
            });
        });
    },
    onSignup: () => {
        $('#signup_form').on('submit', function(e) {
            e.preventDefault();

            const formValues = $(this).serialize();
            const route = $(this).attr('action');
            const button = $(this).find('button[type="submit"]');

            $.ajax({
                url: route,
                method: 'POST',
                data: formValues,
                beforeSend: () => {
                    __HELPER__.element(button).disable();
                },
                success: (response) => {
                    __HELPER__.toast().success("Đăng ký thành công!");
                    __HELPER__.urlParams('overlay').del();

                    setTimeout(() => window.location.reload(), 500);
                },
                error: () => {
                    __HELPER__.toast().error("Đăng ký không thành công!");
                },
            });
        });
    },
    onForgotPassword: () => {},
};

AUTHENTICATION_OVERLAY.init();
AUTHENTICATION_HANDLER.init();
