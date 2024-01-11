<quick-add-modal class="quick-add-modal modal-authentication" open>
    <div role="dialog" aria-label="Address Modal" aria-modal="true" class="quick-add-modal__content global-settings-popup no-bottom mobile-position-center" tabindex="-1">
        <button id="ModalClose-4441599705221" type="button" class="quick-add-modal__toggle" aria-label="Close" data-overlay-close="">
            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" role="presentation" class="icon icon-close" fill="none" viewBox="0 0 18 17">
                <path d="M.865 15.978a.5.5 0 00.707.707l7.433-7.431 7.579 7.282a.501.501 0 00.846-.37.5.5 0 00-.153-.351L9.712 8.546l7.417-7.416a.5.5 0 10-.707-.708L8.991 7.853 1.413.573a.5.5 0 10-.693.72l7.563 7.268-7.418 7.417z" fill="currentColor"></path>
            </svg>
        </button>
        <div class="quick-add-modal__content-info">
            <div data-overlay-action-wrapper="create-address">
                <div class="quick-add-modal__content-heading" style="margin-bottom: 20px;">
                    <h3 class="ls-box-title text-left">Thêm địa chỉ</h3>
                </div>
                <div class="quick-add-modal__content-content">
                    <div class="form-basic-create-address customer">
                        <form method="POST" action="{{ route('fe.api.user.address.store') }}" id="create_address_form" accept-charset="UTF-8" class="create-address-form">
                            <div class="section-content section-customer-information">
                                <div class="fieldset">
                                    <div class="field field-required">
                                        <div class="field-input-wrapper">
                                            <label class="field-label" for="">Họ và tên</label>
                                            <input type="text" placeholder="Họ và tên" autocapitalize="off" spellcheck="false" class="field-input" size="30" value="" autocomplete="false">
                                        </div>
                                    </div>
                                    <div class="field field-required">
                                        <div class="field-input-wrapper">
                                            <label class="field-label" for="">E-mail</label>
                                            <input type="email" placeholder="E-mail" autocapitalize="off" spellcheck="false" class="field-input" size="30" value="" autocomplete="false">
                                        </div>
                                    </div>
                                    <div class="field field-required">
                                        <div class="field-input-wrapper">
                                            <label class="field-label" for="">Số điện thoại</label>
                                            <input type="tel" placeholder="Số điện thoại" autocapitalize="off" spellcheck="false" class="field-input" size="30" value="" autocomplete="false">
                                        </div>
                                    </div>

                                    <div>
                                        <div class="field field-show-floating-label field-required field-third ">
                                            <div class="field-input-wrapper field-input-wrapper-select">
                                                <label class="field-label" for="customer_shipping_province"> Tỉnh / thành </label>
                                                <select class="field-input" id="customer_shipping_province" name="customer_shipping_province">
                                                    <option data-code="null" value="null" selected=""> Chọn tỉnh / thành </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="field field-show-floating-label field-required field-third ">
                                            <div class="field-input-wrapper field-input-wrapper-select">
                                                <label class="field-label" for="customer_shipping_district">Quận / huyện</label>
                                                <select class="field-input" id="customer_shipping_district" name="customer_shipping_district">
                                                    <option data-code="null" value="null" selected="">Chọn quận / huyện</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="field field-show-floating-label field-required  field-third  ">
                                            <div class="field-input-wrapper field-input-wrapper-select">
                                                <label class="field-label" for="customer_shipping_ward">Phường / xã</label>
                                                <select class="field-input" id="customer_shipping_ward" name="customer_shipping_ward">
                                                    <option data-code="null" value="null" selected="">Chọn phường / xã</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field field-required">
                                        <div class="field-input-wrapper">
                                            <label class="field-label" for="">Địa chỉ</label>
                                            <textarea name="" class="field-input" cols="30" rows="3" placeholder="Địa chỉ"></textarea>
                                        </div>
                                    </div>
                                    <div class="field field-required">
                                        <label class="container">
                                            <div style="font-size: 15px; padding-top: 1px;">Đặt làm địa chỉ mặt định</div>
                                            <input type="checkbox" checked="checked">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="field field-required">
                                        <button type="submit" class="step-footer-continue-btn btn" style="width: 100%; margin-top: 10px; padding: 13px; font-weight: 400;">
                                            <span class="btn-content">Thêm địa chỉ</span>
                                            <i class="btn-spinner icon icon-button-spinner"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</quick-add-modal>
