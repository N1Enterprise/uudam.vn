<div id="section-payment-method" class="section">
    <div class="order-checkout__loading--box">
        <div class="order-checkout__loading--circle"></div>
    </div>
    <div class="section-header">
        <h2 class="section-title">Phương thức thanh toán</h2>
    </div>
    <div class="section-content">
        <div class="content-box">
            @foreach ($paymentOptions as $paymentOption)
            <div class="radio-wrapper content-box-row">
                <label class="radio-label" for="payment_option_id_{{ data_get($paymentOption, 'id') }}">
                    <div class="radio-input payment-method-checkbox">
                        <input type-id="1" id="payment_option_id_{{ data_get($paymentOption, 'id') }}" class="input-radio" name="payment_option_id" type="radio" value="{{ data_get($paymentOption, 'id') }}" {{ $loop->index == 0 ? 'checked' : '' }}>
                    </div>
                    <div class="radio-content-input">
                        <img class="main-img" src="{{ data_get($paymentOption, 'logo') }}" alt="{{ data_get($paymentOption, 'name') }}">
                        <div>
                            <span class="radio-label-primary">{{ data_get($paymentOption, 'name') }}</span>
                            <span class="quick-tagline hidden"></span>
                        </div>
                    </div>
                </label>
            </div>
            @if (data_get($paymentOption, 'expanded_content'))
            <div id="expanded_content_{{ data_get($paymentOption, 'id') }}" data-expanded-content-payment-option-id="{{ data_get($paymentOption, 'id') }}" style="display: none; text-align: center;" class="radio-wrapper content-box-row content-box-row-padding content-box-row-secondary">
                @php
                    $orderTransferContent = implode('', [
                        data_get($cart, 'id'),
                        data_get($cart, 'currency_code'),
                        data_get($cart, 'total_quantity'),
                    ]);
                    
                    $expandedContent = str_replace('${order_transfer_content}', $orderTransferContent, data_get($paymentOption, 'expanded_content'));
                @endphp

                <p>{!! nl2br($expandedContent) !!}</p>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</div>