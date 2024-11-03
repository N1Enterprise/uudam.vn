@extends('frontend.layouts.profile')

@section('page_title')
{{ get_static_page_seo_title('profile_account', [':user_name' => data_get($AUTHENTICATED_USER, 'name')]) }}
@endsection

@section('page_seo')
{!! generate_static_page_seo_html('profile_account', [':user_name' => data_get($AUTHENTICATED_USER, 'name')]) !!}
@endsection

@section('profile_style')
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/pages/profile.min.css') }}">
@endsection

@section('profile_content')
<div class="profile-user-info">
    <h4>Thông tin tài khoản</h4>
    <a href="{{ route('fe.api.user.signout') }}" id="User_SignOut">
        <div style="display: flex; align-items: center;">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none">
                <path d="M12 20C7.58172 20 4 16.4183 4 12C4 7.58172 7.58172 4 12 4" stroke="#000" stroke-width="1.5" stroke-linecap="round"/>
                <path d="M10 12H20M20 12L17 9M20 12L17 15" stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            <span>Đăng xuất</span>
        </div>
    </a>

    <form action="{{ route('fe.api.user.update-info') }}" method="POST" data-form="user-info">
        <div class="form-fields">
            <div class="form-group">
                <div class="field field--with-error" style="margin: 5px 0;">
                    <input type="text" name="name" id="name" value="{{ data_get($AUTHENTICATED_USER, 'name') }}" class="field__input" autocomplete="name" value placeholder="Họ tên" required>
                    <label class="field__label" for="name">Họ tên <span>*</span></label>
                </div>
            </div>

            <div class="form-group">
                <div class="field field--with-error" style="margin: 5px 0;">
                    <input type="text" name="email" id="email" value="{{ data_get($AUTHENTICATED_USER, 'email') }}" class="field__input" autocomplete="phone" placeholder="E-mail">
                    <label class="field__label" for="email">E-mail <span> (không yêu cầu nhập)</span></label>
                </div>
            </div>

            <div class="form-group">
                <div class="field field--with-error" style="margin: 5px 0;">
                    <input type="text" name="phone_number" id="phone_number" value="{{ data_get($AUTHENTICATED_USER, 'phone_number') }}" class="field__input" autocomplete="phone" value required placeholder="Số Điện Thoại / Email">
                    <label class="field__label" for="phone_number">Số điện thoại <span>*</span></label>
                </div>
            </div>

            <div class="form-group">
                <div class="field field--with-error" style="margin: 5px 0;">
                    <input type="date" name="birthday" id="birthday" value="{{ data_get($AUTHENTICATED_USER, 'birthday') }}" class="field__input" autocomplete="birthday" value placeholder="Số Điện Thoại">
                    <label class="field__label" for="birthday">Sinh nhật</label>
                </div>
            </div>

            <button type="submit" class="button" style="display: block; width: 100%; margin-bottom: 5px;" data-button-submit-text>Lưu thay đổi</button>
        </div>
        </div>
    </form>
</div>
@endsection

@section('profile_js')
<script src="{{ asset_with_version('frontend/bundle/js/profile-user-info.min.js') }}"></script>
@endsection
