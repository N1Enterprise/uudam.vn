<div class="section-header">
    <h2 class="section-title">Thông tin giao hàng</h2>
</div>
<div class="section-content section-customer-information">
    <div class="fieldset">
        <div class="field field-required">
            <div class="field-input-wrapper">
                <label class="field-label" for="billing_address_full_name">Họ và tên</label>
                <input placeholder="Họ và tên" autocapitalize="off" spellcheck="false" class="field-input" size="30" type="text" id="billing_address_full_name" name="billing_address[full_name]" value="{{ data_get($AUTHENTICATED_USER, 'name') ?? '' }}" autocomplete="false">
            </div>
        </div>
        <div class="field  field-two-thirds">
            <div class="field-input-wrapper">
                <label class="field-label" for="checkout_user_email">Email</label>
                <input autocomplete="false" placeholder="Email" autocapitalize="off" spellcheck="false" class="field-input" size="30" type="email" id="checkout_user_email" name="checkout_user[email]" value="{{ data_get($AUTHENTICATED_USER, 'email') ?? '' }}">
            </div>
        </div>
        <div class="field field-required field-third">
            <div class="field-input-wrapper">
                <label class="field-label" for="billing_address_phone">Số điện thoại</label>
                <input autocomplete="false" placeholder="Số điện thoại" autocapitalize="off" spellcheck="false" class="field-input" size="30" maxlength="15" type="tel" id="billing_address_phone" name="billing_address[phone]" value="{{ data_get($AUTHENTICATED_USER, 'phone_number') ?? '' }}">
            </div>
        </div>
        <div class="field">
            <a href="javascript:void(0)" class="show-modal-add-address" style="display: flex; align-items: center;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#338dbc" width="25" height="25" viewBox="0 0 256 256" id="Flat">
                    <path d="M154.69775,142.7522a36,36,0,1,0-37.3955,0,63.58192,63.58192,0,0,0-32.50342,22.8435,4,4,0,1,0,6.39648,4.80469,56.0083,56.0083,0,0,1,89.60742-.00195,4,4,0,1,0,6.39649-4.80469A63.578,63.578,0,0,0,154.69775,142.7522ZM108,112a28,28,0,1,1,28,28A28.03146,28.03146,0,0,1,108,112ZM208,28H64A12.01343,12.01343,0,0,0,52,40V64H32a4,4,0,0,0,0,8H52v32H32a4,4,0,0,0,0,8H52v32H32a4,4,0,0,0,0,8H52v32H32a4,4,0,0,0,0,8H52v24a12.01343,12.01343,0,0,0,12,12H208a12.01343,12.01343,0,0,0,12-12V40A12.01343,12.01343,0,0,0,208,28Zm4,188a4.00427,4.00427,0,0,1-4,4H64a4.00427,4.00427,0,0,1-4-4V40a4.00427,4.00427,0,0,1,4-4H208a4.00427,4.00427,0,0,1,4,4Z"/>
                </svg>
                <span>Thêm địa chỉ mới</span>
            </a>
        </div>
    </div>
</div>