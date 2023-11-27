<div id="shippingAddressForm">
    <div aria-hidden="false" class="pxSEU">
        <div class="_1ip0g651 _1fragemfi _1frageme0 _1fragemg1 _1fragemgi">

            <input type="hidden" name="email" value="{{ data_get($AUTHENTICATED_USER, 'email') }}">

            <div class="form-group">
                <div class="_1frageme0 _1fragemfi _1mrl40q3 _1fragemg1 _1fragemgi _16s97g7c _16s97g7k _16s97g718 _16s97g71g" style="--_16s97g78: minmax(0, 1fr); --_16s97g7g: minmax(0, 1fr); --_16s97g714: minmax(0, 1fr); --_16s97g71c: minmax(0, 1fr);">
                    <div class="vTXBW _1fragemf1 _10vrn9p1 _10vrn9p0 _10vrn9p4">
                        <div>
                            <div class="j2JE7 _1fragemf1">
                                <label for="Select0" class="QOQ2V NKh24">
                                    <span class="KBYKh">
                                        <span class="rermvf1 _1fragemkt _1fragemkv _1fragemfc">Quốc gia/Khu vực</span>
                                    </span>
                                </label>
                                <select name="country_code" id="Select0" required autocomplete="quốc gia vận chuyển" class="_b6uH _1fragemm8 yA4Q8 vYo81 RGaKd" {{ disabled_input(!$editable) }}>
                                    @foreach ($countries as $country)
                                    <option {{ $order->country_code == $country->iso2 ? 'selected' : '' }} value="{{ $country->iso2 }}">{{ data_get($country, 'native', $country->name) }}</option>
                                    @endforeach
                                </select>
                                <div class="TUEJq">
                                    <span class="_1fragemhb _1fragem1w _1fragemd8 _1fragemd4 a8x1wu3 _1fragemfc a8x1wug a8x1wum">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14" focusable="false" aria-hidden="true" class="a8x1wuo _1fragemfc _1fragemhb _1fragemd8 _1fragemd4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m11.9 5.6-4.653 4.653a.35.35 0 0 1-.495 0L2.1 5.6"></path>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="_1frageme0 _1fragemfi _1mrl40q3 _1fragemg1 _1fragemgi _16s97g7c _16s97g7k _16s97g718 _16s97g71g" style="--_16s97g78: minmax(0, 1fr); --_16s97g7g: minmax(0, 1fr); --_16s97g714: minmax(0, 1fr); --_16s97g71c: minmax(0, 1fr);">
                    <div class="_7ozb2u2 _1fragemfx _1fragemge _1frageme0 _1fragemfi _10vrn9p1 _10vrn9p0 _10vrn9p4 _1fragemf1">
                        <div class="_1frageme0">
                            <label for="checkout_ref_fullname" class="cektnc3 _1fragemds _1fragemld _1fragemkw _1fragemm2 _1fragemlr _1fragemlm _1fragemm0">
                                <span class="cektnc9">
                                    <span class="rermvf1 _1fragemkt _1fragemkv _1fragemfc">Họ tên người nhận</span>
                                </span>
                            </label>
                            <div class="_7ozb2u6 _1frageme0 _1fragemfi _1fragemfb _1fragemlr _1fragemlm _1fragemm0 _1fragemm1 _1fragemf1 _1fragemm8 _7ozb2ul _7ozb2uh">
                                <input name="fullname" value="{{ data_get($order, 'fullname', data_get($AUTHENTICATED_USER, 'name')) }}" {{ disabled_input(!$editable) }} id="checkout_ref_fullname" placeholder="Họ tên người nhận" type="text" aria-required="false" autocomplete="shipping organization" class="_7ozb2uq _1frageme0 _1fragemm2 _1fragemhb _1fragemlc _7ozb2ur _7ozb2u11 _7ozb2u1j" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="_1frageme0 _1fragemfi _1mrl40q3 _1fragemg1 _1fragemgi _16s97g7c _16s97g7k _16s97g718 _16s97g71g" style="--_16s97g78: minmax(0, 1fr); --_16s97g7g: minmax(0, 1fr); --_16s97g714: minmax(0, 1fr); --_16s97g71c: minmax(0, 1fr);">
                    <div class="_7ozb2u2 _1fragemfx _1fragemge _1frageme0 _1fragemfi _10vrn9p1 _10vrn9p0 _10vrn9p4 _1fragemf1">
                        <div class="_1frageme0">
                            <label id="TextField2-label" for="TextField2" class="cektnc3 _1fragemds _1fragemld _1fragemkw _1fragemm2 _1fragemlr _1fragemlm _1fragemm0">
                                <span class="cektnc9">
                                    <span class="rermvf1 _1fragemkt _1fragemkv _1fragemfc">Công ty (không bắt buộc)</span>
                                </span>
                            </label>
                            <div class="_7ozb2u6 _1frageme0 _1fragemfi _1fragemfb _1fragemlr _1fragemlm _1fragemm0 _1fragemm1 _1fragemf1 _1fragemm8 _7ozb2ul _7ozb2uh">
                                <input name="company" value="{{ data_get($order, 'company') }}" {{ disabled_input(!$editable) }} placeholder="Công ty (không bắt buộc)" type="text" aria-required="false" autocomplete="shipping organization" class="_7ozb2uq _1frageme0 _1fragemm2 _1fragemhb _1fragemlc _7ozb2ur _7ozb2u11 _7ozb2u1j">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="_1frageme0 _1fragemfi _1mrl40q3 _1fragemg1 _1fragemgi _16s97g7c _16s97g7k _16s97g718 _16s97g71g" style="--_16s97g78: minmax(0, 1fr); --_16s97g7g: minmax(0, 1fr); --_16s97g714: minmax(0, 1fr); --_16s97g71c: minmax(0, 1fr);">
                    <div class="Vob8N">
                        <div class="_1ip0g651 _1fragemfi _1frageme0 _1fragemfz _1fragemgg">
                            <div class="_7ozb2u2 _1fragemfx _1fragemge _1frageme0 _1fragemfi _10vrn9p1 _10vrn9p0 _10vrn9p4 _1fragemf1">
                                <div class="_1frageme0">
                                    <label id="TextField3-label" for="TextField3" class="cektnc3 _1fragemds _1fragemld _1fragemkw _1fragemm2 _1fragemlr _1fragemlm _1fragemm0">
                                        <span class="cektnc9">
                                            <span class="rermvf1 _1fragemkt _1fragemkv _1fragemfc">Địa chỉ nhận</span>
                                        </span>
                                    </label>
                                    <div class="_7ozb2u6 _1frageme0 _1fragemfi _1fragemfb _1fragemlr _1fragemlm _1fragemm0 _1fragemm1 _1fragemf1 _1fragemm8 _7ozb2ul _7ozb2uh">
                                        <input name="address_line" value="{{ data_get($order, 'address_line') }}" {{ disabled_input(!$editable) }} placeholder="Địa chỉ nhận" type="text" aria-required="true" autocomplete="shipping address line" data-protected-input="true" class="_7ozb2uq _1frageme0 _1fragemm2 _1fragemhb _1fragemlc _7ozb2ur _7ozb2u11 _7ozb2u1j" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="_1frageme0 _1fragemfi _1mrl40q3 _1fragemg1 _1fragemgi _16s97g7c _16s97g7k _16s97g718 _16s97g71g" style="--_16s97g78: minmax(0, 1fr); --_16s97g7g: minmax(0, 1fr); --_16s97g714: minmax(0, 1fr); --_16s97g71c: minmax(0, 1fr);">
                <div class="form-group">
                    <div class="_7ozb2u2 _1fragemfx _1fragemge _1frageme0 _1fragemfi _10vrn9p1 _10vrn9p0 _10vrn9p4 _1fragemf1">
                        <div class="_1frageme0">
                            <label for="checkout_ref_city_name" class="cektnc3 _1fragemds _1fragemld _1fragemkw _1fragemm2 _1fragemlr _1fragemlm _1fragemm0">
                                <span class="cektnc9">
                                    <span class="rermvf1 _1fragemkt _1fragemkv _1fragemfc">Thành phố</span>
                                </span>
                            </label>
                            <div class="_7ozb2u6 _1frageme0 _1fragemfi _1fragemfb _1fragemlr _1fragemlm _1fragemm0 _1fragemm1 _1fragemf1 _1fragemm8 _7ozb2ul _7ozb2uh">
                                <input id="checkout_ref_city_name" value="{{ data_get($order, 'city_name') }}" {{ disabled_input(!$editable) }} name="city_name" placeholder="Thành phố" type="text" aria-required="true" autocomplete="shipping address-level2" class="_7ozb2uq _1frageme0 _1fragemm2 _1fragemhb _1fragemlc _7ozb2ur _7ozb2u11 _7ozb2u1j" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="ii1aN">
                        <div class="_7ozb2u2 _1fragemfx _1fragemge _1frageme0 _1fragemfi _10vrn9p1 _10vrn9p0 _10vrn9p4 _1fragemf1">
                            <div class="_1frageme0">
                                <label for="checkout_ref_postal_code" for="TextField5" class="cektnc3 _1fragemds _1fragemld _1fragemkw _1fragemm2 _1fragemlr _1fragemlm _1fragemm0">
                                    <span class="cektnc9">
                                        <span class="rermvf1 _1fragemkt _1fragemkv _1fragemfc">mã bưu điện (không bắt buộc)</span>
                                    </span>
                                </label>
                                <div class="_7ozb2u6 _1frageme0 _1fragemfi _1fragemfb _1fragemlr _1fragemlm _1fragemm0 _1fragemm1 _1fragemf1 _1fragemm8 _7ozb2ul _7ozb2uh">
                                    <input name="postal_code" value="{{ data_get($order, 'postal_code') }}" {{ disabled_input(!$editable) }} id="checkout_ref_postal_code" placeholder="mã bưu điện (không bắt buộc)" type="text" inputmode="numeric" aria-required="true" autocomplete="shipping postal-code" autocapitalize="characters" class="_7ozb2uq _1frageme0 _1fragemm2 _1fragemhb _1fragemlc _7ozb2ur _7ozb2u11 _7ozb2u1j">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="_1frageme0 _1fragemfi _1mrl40q3 _1fragemg1 _1fragemgi _16s97g7c _16s97g7k _16s97g718 _16s97g71g" style="--_16s97g78: minmax(0, 1fr); --_16s97g7g: minmax(0, 1fr); --_16s97g714: minmax(0, 1fr); --_16s97g71c: minmax(0, 1fr);">
                <div class="form-group">
                    <div class="_7ozb2u2 _1fragemfx _1fragemge _1frageme0 _1fragemfi _10vrn9p1 _10vrn9p0 _10vrn9p4 _1fragemf1">
                        <div class="_1frageme0">
                            <label id="TextField6-label" for="TextField6" class="cektnc3 _1fragemds _1fragemld _1fragemkw _1fragemm2 _1fragemlr _1fragemlm _1fragemm0">
                                <span class="cektnc9">
                                    <span class="rermvf1 _1fragemkt _1fragemkv _1fragemfc">Số điện thoại</span>
                                </span>
                            </label>
                            <div class="_7ozb2u6 _1frageme0 _1fragemfi _1fragemfb _1fragemlr _1fragemlm _1fragemm0 _1fragemm1 _1fragemf1 _1fragemm8 _7ozb2ul _7ozb2uh">
                                <input name="phone" value="{{ data_get($order, 'phone', data_get($AUTHENTICATED_USER, 'phone_number')) }}" {{ disabled_input(!$editable) }} placeholder="Số điện thoại" required type="tel" aria-required="true" aria-labelledby="TextField6-label" autocomplete="shipping tel" data-protected-input="true" class="_7ozb2uq _1frageme0 _1fragemm2 _1fragemhb _1fragemlc _7ozb2ur _1fragemhx _1fragemi7 _7ozb2u10 _7ozb2u1j">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
