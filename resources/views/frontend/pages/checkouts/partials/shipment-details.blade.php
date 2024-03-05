<div class="section-header">
    <h2 class="section-title">Thông tin giao hàng</h2>
</div>
<div class="section-content section-customer-information">
    <div class="fieldset">
        <div class="field">
            @if(has_data($address))
            <div id="user_address" data-address-id="{{ data_get($address, 'id') }}">
                <b style="margin-bottom: 4px; display: block;">Giao tới:</b>
                <div>
                    <span>{{ data_get($address, 'name') }}</span> | <span>{{ data_get($address, 'phone') }}</span>
                    <p>{{ data_get($address, 'full_address') }}</p>
                    <a href="javascript:void(0)" address-editable-btn style="margin-top: 5px;" data-address-code="{{ data_get($address, 'code') }}">Chỉnh sửa</a>
                </div>
            </div>
            @else
            <a href="javascript:void(0)" class="show-modal-add-address" style="display: flex; align-items: center;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#338dbc" width="25" height="25" viewBox="0 0 256 256" id="Flat">
                    <path d="M154.69775,142.7522a36,36,0,1,0-37.3955,0,63.58192,63.58192,0,0,0-32.50342,22.8435,4,4,0,1,0,6.39648,4.80469,56.0083,56.0083,0,0,1,89.60742-.00195,4,4,0,1,0,6.39649-4.80469A63.578,63.578,0,0,0,154.69775,142.7522ZM108,112a28,28,0,1,1,28,28A28.03146,28.03146,0,0,1,108,112ZM208,28H64A12.01343,12.01343,0,0,0,52,40V64H32a4,4,0,0,0,0,8H52v32H32a4,4,0,0,0,0,8H52v32H32a4,4,0,0,0,0,8H52v32H32a4,4,0,0,0,0,8H52v24a12.01343,12.01343,0,0,0,12,12H208a12.01343,12.01343,0,0,0,12-12V40A12.01343,12.01343,0,0,0,208,28Zm4,188a4.00427,4.00427,0,0,1-4,4H64a4.00427,4.00427,0,0,1-4-4V40a4.00427,4.00427,0,0,1,4-4H208a4.00427,4.00427,0,0,1,4,4Z"/>
                </svg>
                <span>Thêm địa chỉ mới</span>
            </a>
            @endif
        </div>
    </div>
</div>