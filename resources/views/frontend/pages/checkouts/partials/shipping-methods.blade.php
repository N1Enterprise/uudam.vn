<div id="section-shipping-methods">
    <div class="order-checkout__loading--box">
        <div class="order-checkout__loading--circle"></div>
    </div>
    <div class="section-header">
        <h2 class="section-title">Phương thức vận chuyển</h2>
    </div>
    @if (has_data($address))
        @if (has_data($shippingOptions))
        <div class="section-content">
            <div class="content-box">
                <div class="content-box-row">
                    @foreach ($shippingOptions as $option)
                    <div class="radio-wrapper content-box-row">
                        <label class="radio-label" for="shipping_option_{{ data_get($option, 'id') }}">
                            <div class="radio-input">
                                <input id="shipping_option_{{ data_get($option, 'id') }}" class="input-radio" name="shipping_option_id" data-order-estimate-grand-total=" - " data-fee-formatted=" — " type="radio" value="{{ data_get($option, 'id') }}" {{ $loop->index == 0 ? 'checked' : '' }}>
                            </div>
                            <div class="radio-content-input">
                                <img class="main-img" src="{{ data_get($option, 'logo') }}" alt="{{ data_get($option, 'name') }}">
                                <span class="radio-label-primary">{{ data_get($option, 'name') }}</span>
                                <span class="radio-accessory content-box-emphasis" shipping-rate-value-by-option="{{ data_get($option, 'id') }}">...</span>
                            </div>
                        </label>
                    </div>
                    @if (data_get($option, 'expanded_content'))
                    <div id="expanded_content_{{ data_get($option, 'id') }}" data-expanded-content-shipping-option-id="{{ data_get($option, 'id') }}" style="display: none; text-align: center;" class="radio-wrapper content-box-row content-box-row-padding content-box-row-secondary">
                        <p>{{ data_get($option, 'expanded_content') }}</p>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
        @else
        <div class="section-content">
            <div class="content-box  blank-slate">
                <i class="blank-slate-icon icon icon-closed-box "></i>
                <p>Hiện tại chúng tôi chưa hỗ trợ giao hàng tới địa điểm của bạn.</p>
            </div>
        </div>
        @endif
    @else
    <div class="section-content">
        <div class="content-box  blank-slate">
            <i class="blank-slate-icon icon icon-closed-box "></i>
            <p>Vui lòng chọn tỉnh / thành để có danh sách phương thức vận chuyển.</p>
        </div>
    </div>
    @endif
</div>