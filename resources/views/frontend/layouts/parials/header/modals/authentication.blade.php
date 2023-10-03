<quick-add-modal data-overlay-wrapper style="display: none;" class="quick-add-modal modal-authentication" open>
    <div role="dialog" aria-label="User Authentication" aria-modal="true" class="quick-add-modal__content global-settings-popup no-bottom mobile-position-center" tabindex="-1">
        <button id="ModalClose-4441599705221" type="button" class="quick-add-modal__toggle" aria-label="Close" data-overlay-close>
            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" role="presentation" class="icon icon-close" fill="none" viewBox="0 0 18 17">
                <path d="M.865 15.978a.5.5 0 00.707.707l7.433-7.431 7.579 7.282a.501.501 0 00.846-.37.5.5 0 00-.153-.351L9.712 8.546l7.417-7.416a.5.5 0 10-.707-.708L8.991 7.853 1.413.573a.5.5 0 10-.693.72l7.563 7.268-7.418 7.417z" fill="currentColor"></path>
            </svg>
        </button>
        <div class="quick-add-modal__content-info">
            <div data-overlay-action-wrapper="forgot-password" style="display: none;">
                <div class="quick-add-modal__content-heading" style="margin-bottom: 20px;">
                    <h3 class="ls-box-title text-left">Quên Mật Khẩu</h3>
                </div>
                <div class="quick-add-modal__content-content">
                    <div class="form-basic-forgot-password customer">
                        <form method="POST" action="" id="forgot_password_form" accept-charset="UTF-8" class="forgot-password-form">
                            <div class="form-fields">
                                <div class="field field--with-error" style="margin-bottom: 15px;">
                                    <input type="text" name="email" id="forgot-password-email" class="field__input" autocomplete="email" value="" aria-required="true" required="" placeholder="Nhập E-mail">
                                    <label class="field__label" for="forgot-password-email">E-mail <span aria-hidden="true">*</span></label>
                                </div>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <a href="?overlay=signin" data-overlay-action-button="signin" class="redirect-link" style="display: inline-block; margin-bottom: 15px;">Đăng Nhập?</a>
                            </div>
                            <button type="submit" class="button" style="display: block; width: 100%; margin-bottom: 5px;">Khôi Phục Mật Khẩu</button>
                        </form>
                    </div>
                    <div class="form-social-signup"></div>
                </div>
            </div>

            <div data-overlay-action-wrapper="signin" style="display: none;">
                <div class="quick-add-modal__content-heading" style="margin-bottom: 20px;">
                    <h3 class="ls-box-title text-left">Đăng Nhập</h3>
                </div>
                <div class="quick-add-modal__content-content">
                    <div class="form-basic-signin customer">
                        <form method="POST" action="{{ route('fe.user.api.signin') }}" id="signin_form" accept-charset="UTF-8" class="signin-form">
                            @csrf
                            <div class="form-fields">
                                <div class="field field--with-error" style="margin-bottom: 15px;">
                                    <input type="text" name="phone_number" id="signin-phone" class="field__input" autocomplete="phone" value="" aria-required="true" required="" placeholder="Số Điện Thoại">
                                    <label class="field__label" for="signin-phone">Số Điện Thoại<span aria-hidden="true">*</span></label>
                                </div>
                                <div class="field field--with-error" style="margin-bottom: 15px;">
                                    <input type="password" name="password" id="signin-password" class="field__input" value="" autocorrect="off" autocapitalize="off" aria-required="true" required="" placeholder="Mật Khẩu Đăng Nhập">
                                    <label class="field__label" for="signin-password">Mật Khẩu <span aria-hidden="true">*</span></label>
                                </div>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <a href="?overlay=signup" data-overlay-action-button="signup" class="redirect-link" style="display: inline-block; margin-bottom: 15px;">Đăng Ký Tài Khoản?</a>
                                <a href="?overlay=forgot-password" data-overlay-action-button="forgot-password" class="redirect-link" style="display: inline-block; margin-bottom: 15px;">Quên Mật Khẩu?</a>
                            </div>
                            <button type="submit" class="button" style="display: block; width: 100%; margin-bottom: 5px;">Đăng Nhập</button>
                        </form>
                    </div>
                    <div class="form-social-signup"></div>
                </div>
            </div>

            <div data-overlay-action-wrapper="signup" style="display: none;">
                <div class="quick-add-modal__content-heading" style="margin-bottom: 20px;">
                    <h3 class="ls-box-title text-left">Đăng Ký</h3>
                </div>
                <div class="quick-add-modal__content-content">
                    <div class="form-basic-signup customer">
                        <form method="POST" action="{{ route('fe.user.api.signup') }}" id="signup_form" accept-charset="UTF-8" class="signup-form">
                            @csrf
                            <div class="form-fields">
                                <div class="field field--with-error" style="margin-bottom: 15px;">
                                    <input type="text" name="phone_number" id="signup-phone" class="field__input" autocomplete="phone" value="" aria-required="true" required="" placeholder="Số Điện Thoại">
                                    <label class="field__label" for="signup-phone">Số Điện Thoại<span aria-hidden="true">*</span></label>
                                </div>
                                <div class="field field--with-error" style="margin-bottom: 15px;">
                                    <input type="text" name="email" id="signup-email" class="field__input" autocomplete="email" value="" aria-required="true" required="" placeholder="E-mail">
                                    <label class="field__label" for="signup-phone">E-mail<span aria-hidden="true">*</span></label>
                                </div>
                                <div class="field field--with-error" style="margin-bottom: 15px;">
                                    <input type="password" name="password" id="signup-password" class="field__input" value="" autocorrect="off" autocapitalize="off" aria-required="true" required="" placeholder="Mật Khẩu Đăng Nhập">
                                    <label class="field__label" for="signup-password">Mật Khẩu <span aria-hidden="true">*</span></label>
                                </div>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <a href="?overlay=signin" data-overlay-action-button="signin" class="redirect-link" style="display: inline-block; margin-bottom: 15px;">Đăng Nhập?</a>
                            </div>
                            <button type="submit" class="button" style="display: block; width: 100%; margin-bottom: 5px;">Đăng Ký</button>
                        </form>
                    </div>
                    <div class="form-social-signup"></div>
                </div>
            </div>
        </div>
    </div>
</quick-add-modal>
