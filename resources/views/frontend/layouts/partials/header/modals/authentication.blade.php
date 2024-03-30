<quick-add-modal data-overlay-wrapper style="display: none;" class="quick-add-modal modal-authentication" open>
    <div class="quick-add-modal__content global-settings-popup no-bottom mobile-position-center" tabindex="-1">
        <button id="ModalClose-4441599705221" type="button" class="quick-add-modal__toggle" data-overlay-close>
            <svg xmlns="http://www.w3.org/2000/svg" focusable="false" class="icon icon-close" fill="none" viewBox="0 0 18 17">
                <path d="M.865 15.978a.5.5 0 00.707.707l7.433-7.431 7.579 7.282a.501.501 0 00.846-.37.5.5 0 00-.153-.351L9.712 8.546l7.417-7.416a.5.5 0 10-.707-.708L8.991 7.853 1.413.573a.5.5 0 10-.693.72l7.563 7.268-7.418 7.417z" fill="currentColor"></path>
            </svg>
        </button>
        <div class="quick-add-modal__content-info">
            @if(request()->get('overlay') == 'reset-password' && !empty(request()->get('token')) && !empty(request()->get('email')))
            <div data-overlay-action-wrapper="reset-password" style="display: none;">
                <div class="quick-add-modal__content-heading" style="margin-bottom: 20px;">
                    <h3 class="ls-box-title text-left">Nhập mật khẩu mới</h3>
                </div>
                <div class="quick-add-modal__content-content">
                    <div class="form-basic-reset-password customer">
                        <form method="POST" action="{{ route('fe.api.user.reset-password') }}" id="reset_password_form" accept-charset="UTF-8" class="reset-password-form">
                            <input type="hidden" name="token" value="{{ request()->get('token') }}">
                            <input type="hidden" name="email" value="{{ request()->get('email') }}">

                            <div class="form-fields">
                                <div>
                                    <div class="field field--with-error" style="margin-bottom: 15px;">
                                        <input type="text" name="password" id="reset-password-password" class="field__input" autocomplete="password" value="" required="" placeholder="Nhập mật khẩu mới">
                                        <label class="field__label" for="reset-password-password">Mật khẩu mới <span>*</span></label>
                                    </div>
                                    <div class="form-errors" data-name="password"></div>
                                </div>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <a href="?overlay=signin" data-overlay-action-button="signin" class="redirect-link" style="display: inline-block; margin-bottom: 15px;">Đăng nhập?</a>
                            </div>
                            <button type="submit" class="button" style="display: block; width: 100%; margin-bottom: 5px;">Xác nhận thay đổi</button>
                        </form>
                    </div>
                    <div class="form-social-signup"></div>
                </div>
            </div>
            @endif

            <div data-overlay-action-wrapper="forgot-password" style="display: none;">
                <div class="password-reset-pending">
                    <div class="quick-add-modal__content-heading" style="margin-bottom: 20px;">
                        <h3 class="ls-box-title text-left">Quên mật khẩu</h3>
                    </div>
                    <div class="quick-add-modal__content-content">
                        <div class="form-basic-forgot-password customer">
                            <form method="POST" action="{{ route('fe.api.user.forgot-password') }}" id="forgot_password_form" accept-charset="UTF-8" class="forgot-password-form">
                                <div class="form-fields">
                                    <div>
                                        <div class="field field--with-error" style="margin-bottom: 15px;">
                                            <input type="text" name="email" id="forgot-password-email" class="field__input" autocomplete="email" value="" required="" placeholder="Nhập E-mail">
                                            <label class="field__label" for="forgot-password-email">E-mail <span>*</span></label>
                                        </div>
                                        <div class="form-errors" data-name="email"></div>
                                    </div>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <a href="?overlay=signin" data-overlay-action-button="signin" class="redirect-link" style="display: inline-block; margin-bottom: 15px;">Đăng nhập?</a>
                                </div>
                                <button type="submit" class="button" style="display: block; width: 100%; margin-bottom: 5px;">Khôi phục mật khẩu</button>
                            </form>
                        </div>
                        <div class="form-social-signup"></div>
                    </div>
                </div>
                <div class="password-reset-sent-success d-none">
                    <p>E-mail khôi phục mật khẩu đã được gửi tới e-mail <b class="user-mail a-link" style="color: #"></b>,</p>
                    <p>vui lòng kiểm tra e-mail để tiến hành cập nhật mật khẩu mới.</p>
                    <p>
                        Nếu bạn không nhận e-mail vui lòng kiểm tra phần
                        <b>email spam,</b>
                        hoặc liên hệ với chúng tôi qua số điện thoại/zalo:
                        <a href="tel:{{ data_get($SYSTEM_SETTING, 'page_settings.phone_support.phone') }}">{{ data_get($SYSTEM_SETTING, 'page_settings.phone_support.phone') }}</a>
                    </p>
                    <span class="link"></span>
                    <h4>Ưu Đàm xin chân trọng cảm ơn!</h4>
                </div>
            </div>

            <div data-overlay-action-wrapper="signin" style="display: none;">
                <div class="quick-add-modal__content-heading" style="margin-bottom: 20px;">
                    <h3 class="ls-box-title text-left">Đăng nhập</h3>
                </div>
                <div class="quick-add-modal__content-content">
                    <div class="form-basic-signin customer">
                        <form method="POST" action="{{ route('fe.api.user.signin') }}" id="signin_form" accept-charset="UTF-8" class="signin-form">
                            <div class="form-fields">
                                <div>
                                    <div class="field field--with-error" style="margin-bottom: 15px;">
                                        <input type="text" name="username" id="username" class="field__input" autocomplete="phone" required placeholder="Số điện thoại / Email">
                                        <label class="field__label" for="username">Số điện thoại / E-mail <span>*</span></label>
                                    </div>
                                    <div class="form-errors" data-name="username"></div>
                                </div>

                                <div>
                                    <div class="field field--with-error" style="margin-bottom: 15px;">
                                        <input type="password" name="password" id="signin-password" class="field__input" autocorrect="off" autocapitalize="off" required placeholder="Mật khẩu Đăng nhập" autocomplete="current-password">
                                        <label class="field__label" for="signin-password">Mật khẩu <span>*</span></label>
                                    </div>
                                    <div class="form-errors" data-name="password"></div>
                                </div>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <a href="?overlay=signup" data-overlay-action-button="signup" class="redirect-link" style="display: inline-block; margin-bottom: 15px;">Đăng ký tài khoản?</a>
                                <a href="?overlay=forgot-password" data-overlay-action-button="forgot-password" class="redirect-link" style="display: inline-block; margin-bottom: 15px;">Quên mật khẩu?</a>
                            </div>
                            <button type="submit" class="button" style="display: block; width: 100%; margin-bottom: 5px;">Đăng nhập</button>
                            @include('frontend.layouts.partials.header.modals.oauth-authentication')
                        </form>
                    </div>
                    <div class="form-social-signup"></div>
                </div>
            </div>

            <div data-overlay-action-wrapper="signup" style="display: none;">
                <div class="quick-add-modal__content-heading" style="margin-bottom: 20px;">
                    <h3 class="ls-box-title text-left">Đăng ký</h3>
                </div>
                <div class="quick-add-modal__content-content">
                    <div class="form-basic-signup customer">
                        <form method="POST" action="{{ route('fe.api.user.signup') }}" id="signup_form" accept-charset="UTF-8" class="signup-form">
                            <div class="form-fields">
                                <div>
                                    <div class="field field--with-error" style="margin-bottom: 10px;">
                                        <input type="text" name="name" id="signup-name" class="field__input" autocomplete="name" required placeholder="Tên của bạn">
                                        <label class="field__label" for="signup-name">Tên của bạn<span>*</span></label>
                                    </div>
                                    <div class="form-errors" data-name="name"></div>
                                </div>

                                <div>
                                    <div class="field field--with-error" style="margin-bottom: 10px;">
                                        <input type="text" name="phone_number" id="signup-phone" class="field__input" autocomplete="phone" required placeholder="Số điện thoại">
                                        <label class="field__label" for="signup-phone">Số điện thoại<span>*</span></label>
                                    </div>
                                    <div class="form-errors" data-name="phone_number"></div>
                                </div>

                                <div>
                                    <div class="field field--with-error" style="margin-bottom: 10px;">
                                        <input type="text" name="email" id="signup-email" class="field__input" autocomplete="email" placeholder="E-mail">
                                        <label class="field__label" for="signup-phone">E-mail<span> (không yêu cầu nhập)</span></label>
                                    </div>
                                    <div class="form-errors" data-name="email"></div>
                                </div>

                                <div>
                                    <div class="field field--with-error" style="margin-bottom: 10px;">
                                        <input type="text" name="password" id="signup-password" class="field__input" autocorrect="off" autocapitalize="off" required placeholder="Mật khẩu đăng nhập" autocomplete="current-password">
                                        <label class="field__label" for="signup-password">Mật khẩu <span>*</span></label>
                                    </div>
                                    <div class="form-errors" data-name="password"></div>
                                </div>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <a href="?overlay=signin" data-overlay-action-button="signin" class="redirect-link" style="display: inline-block; margin-bottom: 15px;">Đăng nhập?</a>
                            </div>
                            <button type="submit" class="button" style="display: block; width: 100%; margin-bottom: 5px;">Đăng ký</button>
                            @include('frontend.layouts.partials.header.modals.oauth-authentication')
                        </form>
                    </div>
                    <div class="form-social-signup"></div>
                </div>
            </div>
        </div>
    </div>
</quick-add-modal>
