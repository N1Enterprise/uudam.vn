<div class="_16s97g7s" style="--_16s97g7o: span 2;">
    <div class="_1fragemf0 _1fragemey _1fragemfc _1fragemm8 _1fragem2o _1fragem2c _1fragem30 _1fragem24 _1frageme0 _16s97g788">
        <div class="_1fragemfc _1fragem8c _1fragema8 _1fragem6g _1fragemc4 _1frageme4 _16s97g730    _16s97g71w _16s97g724 _16s97g72c _16s97g72k" style="--_16s97g72w: 45.5rem; --_16s97g71s: 0rem; --_16s97g720: auto; --_16s97g728: auto; --_16s97g72g: auto;">
            <aside class="_1fragemfc _1fragem8e _1fragemaa _1fragem6i _1fragemc6 _1frageme0 _16s97g7ac">
                <div class="_1ip0g651 _1fragemfi _1frageme0 _1fragemg3 _1fragemgk">
                    <div class="_1ip0g651 _1fragemfi _1frageme0 _1fragemg3 _1fragemgk">
                        <section class="_1fragemfc _1frageme0">
                            <div class="_1fragemfc _1fragemle _1frageme0">
                                <h2 id="ResourceList0" class="n8k95w1 _1frageme0 n8k95w3">Giỏ hàng</h2>
                            </div>
                            <div role="table" aria-labelledby="ResourceList0" class="_6zbcq55 _1fragemfe _1fragemfk _6zbcq56">
                                <div role="row" class="_6zbcq51d _1fragemfe _1fragemec _1fragemhb _6zbcq51b">
                                    <div role="columnheader" class="_6zbcq51e">
                                        <div class="_1fragemfc _1fragemle _1frageme0">Ảnh sản phẩm</div>
                                    </div>
                                    <div role="columnheader" class="_6zbcq51e">
                                        <div class="_1fragemfc _1fragemle _1frageme0">Mô tả sản phẩm</div>
                                    </div>
                                    <div role="columnheader" class="_6zbcq51e">
                                        <div class="_1fragemfc _1fragemle _1frageme0">Số lượng</div>
                                    </div>
                                    <div role="columnheader" class="_6zbcq51e">
                                        <div class="_1fragemfc _1fragemle _1frageme0">Giá sản phẩm</div>
                                    </div>
                                </div>
                                @foreach ($cartItems as $cartItem)
                                <div role="row" class="_6zbcq524 _1fragemfe _1fragem1w _6zbcq52b" style="display: flex; align-items: flex-start;">
                                    <div role="cell" class="_6zbcq53s _1fragemfe _1fragemfk _1fragemhf">
                                        <div class="_1m6j2n32 _1frageme0 _1fragemmc _1m6j2n33" style="--_1m6j2n30: 1;">
                                            <div class="_1h3po421 _1h3po423 _1frageme0" style="--_1h3po420: 1;">
                                                <picture>
                                                    <source media="(min-width: 0px)" srcset="{{ data_get($cartItem, 'inventory.image') }}">
                                                    <img src="{{ data_get($cartItem, 'inventory.image') }}" alt="{{ data_get($cartItem, 'inventory.title') }}" class="_1h3po424 _1fragemfc _1fragemd8 _1fragemhu _1fragemhz _1fragemi9 _1fragemi4 _1fragem2s _1fragem2g _1fragem34 _1fragem24 _1fragem4g _1fragem3w _1fragem50 _1fragem3c _1fragemdk">
                                                </picture>
                                            </div>
                                            <div class="_1m6j2n3e _1fragemds _1fragemj7 _1fragemjq">
                                                <div aria-hidden="true" class="_99ss3s1 _1fragemfh _1fragemec _1fragemhd _99ss3s4 _99ss3s2 _99ss3s7">{{ data_get($cartItem, 'quantity') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="cell" class="_6zbcq53s _1fragemfe _1fragemfk _1fragemhd _1fragemfn" style="padding-right: 15px;">
                                        <div class="_1fragemfc _1frageme0 iZ894">
                                            <p class="_1x52f9s1 _1frageme0 _1x52f9so _1fragemfq">{{ data_get($cartItem, 'inventory.title') }}</p>
                                            <div class="_1ip0g651 _1fragemfi _1frageme0 _1fragemgb _1fragemgs"></div>
                                        </div>
                                        <div>
                                            @php
                                                $attributeValues = data_get($cartItem, 'inventory.attributeValues')->pluck('value', 'attribute_id')->toArray();
                                            @endphp
                                            @foreach (data_get($cartItem, 'inventory.attributes', []) as $attribute)
                                            <div class="_1x52f9s1 _1frageme0 _1x52f9sm _1fragemfp _1x52f9si" style="display: flex; align-items: center; font-size: 12px;">
                                                <small style="margin-right: 5px;">{{ data_get($attribute, 'name') }}: </small>
                                                <small>{{ data_get($attributeValues, [data_get($attribute, 'id')]) }}</small>
                                            </div>
                                            @endforeach
                                        </div>
                                        <b>{{ format_price($cartItem->total_price) }}</b>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </section>
                    </div>
                    <div>
                        <div class="_1ip0g651 _1fragemfi _1frageme0 _1fragemg3 _1fragemgk">
                            <section aria-label="Mã giảm giá hoặc thẻ quà tặng" class="_1fragemfc _1frageme0">
                                <div class="_1ip0g651 _1fragemfi _1frageme0 _1fragemg1 _1fragemgi">
                                    <form action="" method="POST" novalidate="" id="Form1" class="_1fragemfd">
                                        <div class="_1frageme0">
                                            <div class="_1frageme0 _1fragemfi _1mrl40q2 _1fragemfx _1fragemgi _16s97g7c _16s97g7k _16s97g718 _16s97g71g" style="--_16s97g78: 1fr; --_16s97g7g: minmax(auto, max-content); --_16s97g714: minmax(0, 1fr) minmax(auto, max-content); --_16s97g71c: minmax(auto, max-content);">
                                                <div class="_7ozb2u2 _1fragemfx _1fragemge _1frageme0 _1fragemfi _10vrn9p1 _10vrn9p0 _10vrn9p4 _1fragemf1">
                                                    <div class="_1frageme0">
                                                        <label id="TextField8-label" for="TextField8" class="cektnc3 _1fragemds _1fragemld _1fragemkw _1fragemm2 _1fragemlr _1fragemlm _1fragemm0">
                                                            <span class="cektnc9">
                                                                <span class="rermvf1 _1fragemkt _1fragemkv _1fragemfc">Mã giảm giá hoặc thẻ quà tặng</span>
                                                            </span>
                                                        </label>
                                                        <div class="_7ozb2u6 _1frageme0 _1fragemfi _1fragemfb _1fragemlr _1fragemlm _1fragemm0 _1fragemm1 _1fragemf1 _1fragemm8 _7ozb2ul _7ozb2uh">
                                                            <input id="TextField8" name="reductions" placeholder="Mã giảm giá hoặc thẻ quà tặng" type="text" aria-labelledby="TextField8-label" class="_7ozb2uq _1frageme0 _1fragemm2 _1fragemhb _1fragemlc _7ozb2ur _7ozb2u11 _7ozb2u1j">
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" disabled="" aria-label="Áp dụng mã giảm giá" class="QT4by rqC98 EbLsk _7QHNJ VDIfJ janiy Fox6W hlBcn">
                                                    <span class="AjwsM">Áp dụng</span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="_1fragemfc _1fragemle _1frageme0">
                                            <button type="submit" tabindex="-1" aria-hidden="true">Áp dụng</button>
                                        </div>
                                    </form>
                                </div>
                            </section>
                        </div>
                    </div>
                    <section class="_1fragemfc _1frageme0">
                        <div class="_1fragemfc _1fragemle _1frageme0">
                            <h2 id="MoneyLine-Heading0" class="n8k95w1 _1frageme0 n8k95w3">Tóm tắt chi phí</h2>
                        </div>
                        <div role="table" aria-labelledby="MoneyLine-Heading0" class="nfgb6p0">
                            <div role="row" class="_1qy6ue61 _1fragemfi _1qy6ue65">
                                <div role="rowheader" class="_1qy6ue67">
                                    <span class="_19gi7yt0 _19gi7yth _1fragemfq">Tổng tiền hàng</span>
                                </div>
                                <div role="cell" class="_1qy6ue68">
                                    <span translate="yes" class="_19gi7yt0 _19gi7yth _1fragemfq _19gi7yt1 notranslate">{{ format_price($cart->total_price) }}</span>
                                </div>
                            </div>
                            <div role="row" class="_1qy6ue61 _1fragemfi _1qy6ue65">
                                <div role="rowheader" class="_1qy6ue67">
                                    <div class="_1ip0g651 _1fragemfi _1frageme0 _1fragemfx _1fragemge">
                                        <div class="_1fragemfe _1frageme0 _1fragemhf">
                                            <div class="_5uqybw2 _1fragemfe _1fragemdc _1fragemfx _1fragemge _1frageme8 _1fragemec _1fragemhf">
                                                <span class="_19gi7yt0 _19gi7yth _1fragemfq">Phí vận chuyển</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="cell" class="_1qy6ue68">
                                    <span translate="yes" class="_19gi7yt0 _19gi7yth _1fragemfq notranslate" data-value-transport-fee>0</span>
                                </div>
                            </div>
                            <div role="row" class="_1x41w3p1 _1fragemfi _1fragemec _1x41w3p5">
                                <div role="rowheader" class="_1x41w3p7">
                                    <span class="_19gi7yt0 _19gi7ytl _1fragemfs _19gi7yt1">Tổng thanh toán:</span>
                                </div>
                                <div role="cell" class="_1x41w3p8">
                                    <div class="_1fragemfe _1frageme0 _1fragemhf">
                                        <div class="_5uqybw2 _1fragemfe _1fragemdc _1fragemfz _1fragemgg _1fragemeb _1fragemhf">
                                            <strong translate="yes" class="_19gi7yt0 _19gi7ytl _1fragemfs _19gi7yt1 notranslate" data-value-total-payment>0</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </aside>
        </div>
    </div>
</div>
