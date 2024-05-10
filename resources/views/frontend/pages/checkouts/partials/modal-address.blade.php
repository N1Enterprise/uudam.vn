<quick-add-modal class="quick-add-modal modal-authentication modal-add-address">
    <div class="quick-add-modal__content global-settings-popup no-bottom mobile-position-center" tabindex="-1">
        <button id="ModalClose-4441599705221" type="button" class="quick-add-modal__toggle" data-overlay-close="">
            <svg xmlns="http://www.w3.org/2000/svg" focusable="false" class="icon icon-close" fill="none" viewBox="0 0 18 17">
                <path d="M.865 15.978a.5.5 0 00.707.707l7.433-7.431 7.579 7.282a.501.501 0 00.846-.37.5.5 0 00-.153-.351L9.712 8.546l7.417-7.416a.5.5 0 10-.707-.708L8.991 7.853 1.413.573a.5.5 0 10-.693.72l7.563 7.268-7.418 7.417z" fill="currentColor"></path>
            </svg>
        </button>
        <div class="quick-add-modal__content-info">
            <div data-overlay-action-wrapper="create-address">
                <div class="quick-add-modal__content-heading" style="margin-bottom: 20px;">
                    <h3 class="ls-box-title text-left" data-form-title-text></h3>
                </div>
                <div class="quick-add-modal__content-content">
                    <div class="form-basic-create-address customer">
                        <form method="{{ empty($address) ? 'POST' : 'PUT' }}" action="{{ empty($address) ? route('fe.api.user.address.store') : route('fe.api.user.address.update', data_get($address, 'code')) }}" id="address-form" accept-charset="UTF-8" class="create-address-form" data-form="create-address">
                            <div class="section-content section-customer-information">
                                <div class="fieldset">
                                    <div class="form-group field field-required field--with-error">
                                        <div class="field-input-wrapper">
                                            <label class="field-label" for="">Họ và tên</label>
                                            <input type="text" name="name" placeholder="Họ và tên" autocapitalize="off" spellcheck="false" class="field-input" size="30" value="{{ data_get($AUTHENTICATED_USER, 'name') }}" autocomplete="false">
                                        </div>
                                    </div>

                                    <div class="form-group field field-required field--with-error">
                                        <div class="field-input-wrapper">
                                            <label class="field-label" for="">E-mail (không yêu cầu nhập)</label>
                                            <input type="email" name="email" placeholder="E-mail (không yêu cầu nhập)" autocapitalize="off" spellcheck="false" class="field-input" size="30" value="{{ data_get($AUTHENTICATED_USER, 'email') }}" autocomplete="false">
                                        </div>
                                    </div>
                                    <div class="form-group field field-required field--with-error">
                                        <div class="field-input-wrapper">
                                            <label class="field-label" for="">Số điện thoại</label>
                                            <input type="tel" name="phone" placeholder="Số điện thoại" autocapitalize="off" spellcheck="false" class="field-input" size="30" value="{{ data_get($AUTHENTICATED_USER, 'phone_number') }}" autocomplete="false">
                                        </div>
                                    </div>

                                    <div class="field use-current-location-to-set-address-wrapper">
                                        <button type="button" use-current-location-to-set-address>
                                            <svg fill="none" viewBox="0 0 20 20" class="b1BHds" style="width: 20px; margin-right: 5px;"><path d="M10 9.17a.83.83 0 1 0 0 1.66.83.83 0 0 0 0-1.66Z" fill="#000" fill-opacity=".87"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M10.63.63v1.9a7.5 7.5 0 0 1 6.84 6.85h1.9v1.24h-1.9a7.5 7.5 0 0 1-6.84 6.85v1.9H9.37v-1.9a7.5 7.5 0 0 1-6.84-6.84H.63V9.37h1.9a7.5 7.5 0 0 1 6.85-6.84V.63h1.24ZM9.37 3.77a6.25 6.25 0 0 0-5.59 5.6h1.85v1.24H3.77a6.25 6.25 0 0 0 5.6 5.6v-1.84h1.24v1.84a6.25 6.25 0 0 0 5.6-5.6h-1.84V9.38h1.84a6.25 6.25 0 0 0-5.6-5.6v1.85H9.38V3.77Z" fill="#000" fill-opacity=".87"></path></svg>
                                            <span>Sử dụng vị trí hiện tại của bạn</span>
                                        </button>
                                    </div>

                                    <div>
                                        <div class="field field-show-floating-label field-required field-third ">
                                            <div class="field-input-wrapper field-input-wrapper-select">
                                                <label class="field-label" for="address_new_shipping_province"> Tỉnh / thành </label>
                                                <select class="field-input" id="address_new_shipping_province" name="province_code" id="address_new_shipping_province">
                                                    <option data-code="null" value="null" selected=""> Chọn tỉnh / thành </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="field field-show-floating-label field-required field-third ">
                                            <div class="field-input-wrapper field-input-wrapper-select">
                                                <label class="field-label" for="address_new_shipping_district">Quận / huyện</label>
                                                <select class="field-input" id="address_new_shipping_district" name="district_code" id="address_new_shipping_district">
                                                    <option data-code="null" value="null" selected="">Chọn quận / huyện</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="field field-show-floating-label field-required  field-third  ">
                                            <div class="field-input-wrapper field-input-wrapper-select">
                                                <label class="field-label" for="address_new_shipping_ward">Phường / xã</label>
                                                <select class="field-input" id="address_new_shipping_ward" name="ward_code" id="address_new_shipping_ward">
                                                    <option data-code="null" value="null" selected="">Chọn phường / xã</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group field field-required field--with-error">
                                        <div class="field-input-wrapper">
                                            <label class="field-label" for="">Địa chỉ</label>
                                            <textarea name="address_line" class="field-input" cols="30" rows="3" placeholder="Địa chỉ"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group field field-required field--with-error">
                                        <label class="container">
                                            <div style="font-size: 15px; padding-top: 1px;">Đặt làm địa chỉ mặt định</div>
                                            <input type="checkbox" name="is_default" checked="checked">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="form-group field field-required field--with-error">
                                        <button type="submit" class="step-footer-continue-btn btn" style="width: 100%; margin-top: 10px; padding: 13px; font-weight: 400;">
                                            <span data-button-submit-text></span>
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
