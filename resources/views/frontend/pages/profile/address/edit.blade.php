@extends('frontend.layouts.profile')

@section('page_title')
{{ get_static_page_seo_title('profile_edit_address', [':full_address' => data_get($address, 'full_address')]) }}
@endsection

@section('page_seo')
{!! generate_static_page_seo_html('profile_edit_address', [':full_address' => data_get($address, 'full_address')]) !!}
@endsection

@section('profile_style')
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/pages/profile.min.css') }}">
@endsection

@php
    $redirectUrl = request()->get('redirect_url');
    $redirectUrl = $redirectUrl ?? route('fe.web.user.localization.address');
@endphp

@section('profile_content')
<div class="">
    <button address-editable-btn style="display: none;" data-address-code="{{ data_get($address, 'code') }}"></button>
    <div class="navigation-wrapper">
        <a href="{{ route('fe.web.user.localization.address') }}" class="navigation-item">Sổ địa chỉ</a>
        <a href="/" class="navigation-item a-prevent">Cập nhật địa chỉ</a>

    </div>
    <div class="address-form modal-add-address">
        <form action="{{ route('fe.api.user.address.update', data_get($address, 'code')) }}" method="PUT" data-form="user-info" novalidate="novalidate" id="address-form" data-redirect="{{ $redirectUrl }}">
            <div class="form-fields">
                <div class="form-group">
                    <div class="field field--with-error" style="margin: 5px 0;">
                        <input type="text" name="name" id="name" value="" class="field__input" autocomplete="name" placeholder="Họ tên" required="">
                        <label class="field__label" for="name">Họ và tên <span>*</span></label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="field field--with-error" style="margin: 5px 0;">
                        <input type="text" name="email" id="email" value="" class="field__input" autocomplete="phone" placeholder="E-mail">
                        <label class="field__label" for="email">E-mail <span> (không yêu cầu nhập)</span></label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="field field--with-error" style="margin: 5px 0;">
                        <input type="text" name="phone" id="phone" value="" class="field__input" autocomplete="phone" required="" placeholder="Số Điện Thoại / Email">
                        <label class="field__label" for="phone">Số điện thoại <span>*</span></label>
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
                        <select class="field-input" id="address_new_shipping_district" name="district_code">
                            <option value="">Chọn quận / huyện</option>
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
                        <label class="field__label" for="phone">Địa chỉ chi tiết <span>*</span></label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="mark_as_default" class="custom-checkout">
                        <div style="font-size: 15px; padding-top: 1px;">Đặt làm địa chỉ mặt định</div>
                        <input type="checkbox" name="is_default" id="mark_as_default">
                        <span class="checkmark"></span>
                    </label>
                </div>

                <button type="submit" class="button" style="display: block; width: 100%; margin-bottom: 5px;" data-button-submit-text="">...</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('profile_js')
<script src="{{ asset_with_version('frontend/bundle/js/address.min.js') }}" type="text/javascript"></script>
<script>
    setTimeout(() => {
        $('[address-editable-btn]').trigger('click');
    }, 300);
</script>
@endsection
