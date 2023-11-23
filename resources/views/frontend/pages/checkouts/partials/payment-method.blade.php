<div>
    <div>
        <section aria-label="Thanh toán" class="_1fragemf0 _1fragemex _1fragemfc _1fragem8c _1fragem99 _1fragema8 _1fragemb5 _1fragem6g _1fragem7d _1fragemc4 _1fragemd1 _1fragemm8 _1frageme0">
            <div class="_1ip0g651 _1fragemfi _1frageme0 _1fragemg1 _1fragemgi">
                <div class="_1ip0g651 _1fragemfi _1frageme0 _1fragemfx _1fragemge">
                    <h2 class="n8k95w1 _1frageme0 n8k95w2">Thanh toán</h2>
                    <p class="_1x52f9s1 _1frageme0 _1x52f9so _1fragemfq _1x52f9si">Tất cả các giao dịch đều được bảo mật và mã hóa.</p>
                </div>
                <div class="_1ip0g651 _1fragemfi _1frageme0 _1fragemg5 _1fragemgm">
                    <div class="_1ip0g651 _1fragemfi _1frageme0 _1fragemg6 _1fragemgn">
                        <div class="_1ip0g651 _1fragemfi _1frageme0 _1fragemg1 _1fragemgi">
                            <div>
                                <div class="_1ip0g651 _1fragemfi _1frageme0 _1fragemg1 _1fragemgi">
                                    <fieldset id="basic">
                                        <legend class="_1fragemle">Chọn phương thức thanh toán</legend>
                                        <div class="Wo4qW ezrb1p3 _1fragemf1 _1fragemm8 NDMe9 NdTJE PuVf0">
                                            @foreach ($paymentOptions as $paymentOption)
                                            <div class="B4zH6 Zb82w HKtYc OpmPd">
                                                <label for="basic-Afterpay" class="yL8c2 ezrb1p5 _1fragemf2 D1RJr">
                                                    <div class="hEGyz">
                                                        <div class="_1frageme0">
                                                            <input
                                                                type="radio"
                                                                name="payment_option_id"
                                                                value="{{ data_get($paymentOption, 'id') }}"
                                                                class="_6hzjvo5 _1fragemfa _1fragemfc _1fragemlr _1fragemll _1fragemlx _6hzjvof _1fragemf1 _1fragemm8 _6hzjvoe _6hzjvob"
                                                                {{ count($paymentOptions) == 1 && $loop->index == 0 ? 'checked' : '' }}
                                                            >
                                                        </div>
                                                        <div class="f5aCe">
                                                            <div style="display: flex; align-items: center;">
                                                                <div class="_1fragemfe _1frageme0 _1fragemhf" style="margin-right: 10px;">
                                                                    <div class="_5uqybw2 _1fragemfe _1fragemdc _1fragemfx _1fragemge _1frageme8 _1fragemec _1fragemhf">
                                                                        <img alt="afterpay" src="{{ data_get($paymentOption, 'logo') }}" role="img" width="38" height="24" class="_1tgdqw61 _1fragemlr _1fragemlm _1fragemm0 _1fragemha">
                                                                    </div>
                                                                </div>
                                                                <div class="_19gi7yt0 _19gi7yth _1fragemfq">{{ data_get($paymentOption, 'name') }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="_16s97g74g _16s97g74x"></div>
    </div>
</div>
