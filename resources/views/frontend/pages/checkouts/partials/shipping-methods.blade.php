<div id="section-shipping-methods">
    <div class="order-checkout__loading--box">
        <div class="order-checkout__loading--circle"></div>
    </div>
    <div class="section-header">
        <h2 class="section-title">Phương thức vận chuyển</h2>
    </div>
    @if (has_data($address))
        @if (has_data($shippingProviders))
        <div class="section-content">
            <div class="content-box">
                <div class="content-box-row">
                    @foreach ($shippingProviders as $provider)
                    <div class="radio-wrapper content-box-row">
                        <label class="radio-label" for="shipping_provider_{{ data_get($provider, 'id') }}">
                            <div class="radio-input">
                                <input id="shipping_provider_{{ data_get($provider, 'id') }}" class="input-radio" name="shipping_provider" type="radio" value="{{ data_get($provider, 'id') }}" {{ $loop->index == 0 ? 'checked' : '' }}>
                            </div>
                            <div class="radio-content-input">
                                <img class="main-img" src="{{ data_get($provider, 'logo') }}" alt="{{ data_get($provider, 'name') }}">
                                <span class="radio-label-primary">{{ data_get($provider, 'name') }}</span>
                                <span class="quick-tagline hidden"></span>
                                <span class="radio-accessory content-box-emphasis" shipping-rate-value-by-provider="{{ data_get($provider, 'id') }}">...</span>
                            </div>
                        </label>
                    </div>
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