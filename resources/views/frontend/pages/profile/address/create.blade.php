@extends('frontend.layouts.profile')

@section('page_title')
Thêm địa chỉ mới | {{ config('app.user_domain') }}
@endsection

@section('page_seo')
<meta property="og:title" content="Thêm địa chỉ mới | {{ config('app.user_domain') }}">
<meta property="og:description" content="Thêm địa chỉ mới | {{ config('app.user_domain') }}">
<meta property="og:url" content="{{ request()->url() }}">
<meta property="og:site_name" content="{{ config('app.user_domain') }} }}">
<meta property="og:type" content="website">
<meta property="og:locale" content="vi_VN">
<meta property="og:price:currency" content="VND">
<meta name="al:ios:app_name" content="{{ data_get($SYSTEM_SETTING, 'page_settings.app_name') }}">
<meta name="al:iphone:app_name" content="{{ data_get($SYSTEM_SETTING, 'page_settings.app_name') }}">
<meta name="al:ipad:app_name" content="{{ data_get($SYSTEM_SETTING, 'page_settings.app_name') }}">
@endsection

@php
    $redirectUrl = request()->get('redirect_url');
    $redirectUrl = $redirectUrl ?? route('fe.web.user.localization.address');
@endphp

@section('profile_content')
<div class="">
    <div class="navigation-wrapper">
        <a href="{{ route('fe.web.user.localization.address') }}" class="navigation-item">Sổ địa chỉ</a>
        <a href="javascript:void(0)" class="navigation-item">Thêm địa chỉ</a>
    </div>
    <div class="address-form">
        <form action="{{ route('fe.api.user.address.store') }}" method="POST" data-form="user-info" novalidate="novalidate" id="address-form" data-redirect="{{ $redirectUrl }}">
            <div class="form-fields">
                <div class="form-group">
                    <div class="field field--with-error" style="margin: 5px 0;">
                        <input type="text" name="name" id="name" value="" class="field__input" autocomplete="name" aria-required="true" placeholder="Họ tên" required="" aria-invalid="false">
                        <label class="field__label" for="name">Họ và tên <span aria-hidden="true">*</span></label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="field field--with-error" style="margin: 5px 0;">
                        <input type="text" name="email" id="email" value="" class="field__input" autocomplete="phone" placeholder="E-mail">
                        <label class="field__label" for="email">E-mail <span aria-hidden="true"> (không yêu cầu nhập)</span></label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="field field--with-error" style="margin: 5px 0;">
                        <input type="text" name="phone" id="phone" value="" class="field__input" autocomplete="phone" aria-required="true" required="" placeholder="Số Điện Thoại / Email">
                        <label class="field__label" for="phone">Số điện thoại <span aria-hidden="true">*</span></label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="field field--with-error" style="margin: 5px 0;">
                        <select class="field-input" id="address_new_shipping_province" name="province_code">
                            <option value="" selected="">Chọn tỉnh / thành</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="field field--with-error" style="margin: 5px 0;">
                        <select class="field-input" id="address_new_shipping_district" name="district_code" disabled>
                            <option value="" selected="">Chọn quận / huyện</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="field field--with-error" style="margin: 5px 0;">
                        <select class="field-input" id="address_new_shipping_ward" name="ward_code" disabled>
                            <option value="" selected="">Phường / xã</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="field field--with-error" style="margin: 5px 0;">
                        <textarea name="address_line" class="field__input" cols="30" rows="5" placeholder="Địa chỉ" style="min-height: 100px;" required></textarea>
                        <label class="field__label" for="phone">Địa chỉ chi tiết <span aria-hidden="true">*</span></label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="mark_as_default" class="custom-checkout">
                        <div style="font-size: 15px; padding-top: 1px;">Đặt làm địa chỉ mặt định</div>
                        <input type="checkbox" name="is_default" id="mark_as_default" checked="checked">
                        <span class="checkmark"></span>
                    </label>
                </div>
                
                <button type="submit" class="button" style="display: block; width: 100%; margin-bottom: 5px;" data-button-submit-text="">Lưu thay đổi</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('profile_js')
<script src="{{ asset_with_version('frontend/bundle/js/address.min.js') }}" type="text/javascript"></script>
@endsection
