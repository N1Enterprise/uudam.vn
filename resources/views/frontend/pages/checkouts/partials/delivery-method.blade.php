<div>
    <div>
        <section class="_1fragemf0 _1fragemex _1fragemfc _1fragem8c _1fragem99 _1fragema8 _1fragemb5 _1fragem6g _1fragem7d _1fragemc4 _1fragemd1 _1fragemm8 _1frageme0">
            <div class="_1ip0g651 _1fragemfi _1frageme0 _1fragemg1 _1fragemgi">
                <div class="_1ip0g651 _1fragemfi _1frageme0 _1fragemfx _1fragemge">
                    <h2 class="n8k95w1 _1frageme0 n8k95w2">Vận chuyển</h2>
                </div>
                <div class="_1ip0g651 _1fragemfi _1frageme0 _1fragemg4 _1fragemgl">
                    <section aria-label="Vận chuyển" class="_1fragemfc _1frageme0">
                        <div class="_1ip0g651 _1fragemfi _1frageme0 _1fragemg1 _1fragemgi">
                            <div class="_1ip0g651 _1fragemfi _1frageme0 _1fragemg4 _1fragemgl">
                                <div class="_1ip0g651 _1fragemfi _1frageme0 _1fragemg1 _1fragemgi">
                                    @include('frontend.pages.checkouts.partials.user_information')
                                </div>
                                <div class="_1ip0g651 _1fragemfi _1frageme0 _1fragemg1 _1fragemgi">
                                    <h3 class="n8k95w1 _1frageme0 n8k95w3">Chọn phương thức vận chuyển</h3>
                                    <div class="yblnR">
                                        <div>
                                            <div class="_1ip0g651 _1fragemfi _1frageme0 _1fragemg3 _1fragemgk">
                                                <div class="_1ip0g651 _1fragemfi _1frageme0 _1fragemfz _1fragemgg">
                                                    <fieldset id="shipping_methods">
                                                        <legend class="_1fragemle">Chọn phương thức vận chuyển</legend>
                                                        @foreach ($shippingRatesCarriers as $shippingRateCarrer)
                                                        <div class="Wo4qW ezrb1p3 _1fragemf1 _1fragemm8 NDMe9 NdTJE PuVf0">
                                                            <div class="B4zH6 Zb82w HKtYc OpmPd">
                                                                <label data-label="Thực hiện bởi {{ data_get($shippingRateCarrer, 'carrier_name') }}" class="yL8c2 ezrb1p5 _1fragemf2 D1RJr">
                                                                    <div class="hEGyz">
                                                                        <div class="f5aCe">
                                                                            <div class="_5uqybw2 _1fragemfe _1fragemdc _1fragemfx _1fragemge _1frageme8 _1fragemec _1fragemhf">
                                                                                <img alt="afterpay" src="{{ data_get($shippingRateCarrer, 'carrier_logo') }}" role="img" width="50" height="50" class="_1tgdqw61 _1fragemlr _1fragemlm _1fragemm0 _1fragemha">
                                                                            </div>
                                                                            <div>
                                                                                <span class="_19gi7yt0 _19gi7yth _1fragemfq">{{ data_get($shippingRateCarrer, 'carrier_name') }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </label>
                                                                <div class="_94sxtb1 _1fragemkt _1fragemkv _1frageme0 _1fragemlt _1fragemlx _1fragemln" style="height: auto; overflow: visible;">
                                                                    <div>
                                                                        <div class="b7U_P" style="display: flex; align-items: center; justify-content: space-between">
                                                                            @foreach (data_get($shippingRateCarrer, 'shipping_rates', []) as $shippingRate)
                                                                            <label for="shipping_option_{{ data_get($shippingRate, 'id') }}" style="display: flex; align-items: flex-start">
                                                                                <input
                                                                                    type="radio"
                                                                                    name="shipping_rate_id"
                                                                                    value="{{ data_get($shippingRate, 'id') }}"
                                                                                    data-rate="{{ data_get($shippingRate, 'rate') }}"
                                                                                    {{ data_get($order, 'shipping_rate_id') == data_get($shippingRate, 'id') ? 'checked' : '' }}
                                                                                    data-total-price-has-shipping="{{ data_get($shippingRate, 'total_price_has_shipping') }}"
                                                                                    id="shipping_option_{{ data_get($shippingRate, 'id') }}"
                                                                                    class="_6hzjvo5 _1fragemfa _1fragemfc _1fragemlr _1fragemll _1fragemlx _6hzjvof _1fragemf1 _1fragemm8 _6hzjvoe _6hzjvob" style="margin-right: 10px; margin-top: 2px;" {{ count(data_get($shippingRateCarrer, 'shipping_rates', [])) == 1 && $loop->index == 0 ? 'checked' : '' }}>
                                                                                <div>
                                                                                    {{ data_get($shippingRate, 'name') }}
                                                                                    <p><small>({{ data_get($shippingRate, 'delivery_takes') }})</small></p>
                                                                                </div>
                                                                            </label>
                                                                            <div>
                                                                                <span style="font-weight: bold;">{{ format_price(data_get($shippingRate, 'rate')) }}</span>
                                                                            </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
        <div class="_16s97g74g _16s97g74x"></div>
    </div>
</div>
