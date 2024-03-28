@extends('frontend.layouts.profile')

@section('page_title')
Thông tin tài khoản | {{ config('app.user_domain') }}
@endsection

@section('page_seo')
{!! generate_seo_html(['page_name' => "Thông tin tài khoản - " . data_get($AUTHENTICATED_USER, 'name')]) !!}
@endsection

@section('profile_content')
<div class="profile-user-info">
    <h4>Thông tin tài khoản</h4>
    <a href="{{ route('fe.api.user.signout') }}" id="User_SignOut">
        <div style="display: flex; align-items: center;">
            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" fill="none" viewBox="0 0 18 19">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M6 4.5a3 3 0 116 0 3 3 0 01-6 0zm3-4a4 4 0 100 8 4 4 0 000-8zm5.58 12.15c1.12.82 1.83 2.24 1.91 4.85H1.51c.08-2.6.79-4.03 1.9-4.85C4.66 11.75 6.5 11.5 9 11.5s4.35.26 5.58 1.15zM9 10.5c-2.5 0-4.65.24-6.17 1.35C1.27 12.98.5 14.93.5 18v.5h17V18c0-3.07-.77-5.02-2.33-6.15-1.52-1.1-3.67-1.35-6.17-1.35z" fill="currentColor"></path>
            </svg>
            <span>Đăng xuất</span>
        </div>
    </a>

    <form action="{{ route('fe.api.user.update-info') }}" method="POST" data-form="user-info">
        <div class="form-fields">
            <div class="form-group">
                <div class="field field--with-error" style="margin: 5px 0;">
                    <input type="text" name="name" id="name" value="{{ data_get($AUTHENTICATED_USER, 'name') }}" class="field__input" autocomplete="name" value aria-required="true" placeholder="Họ tên" required>
                    <label class="field__label" for="name">Họ tên <span aria-hidden="true">*</span></label>
                </div>
            </div>

            <div class="form-group">
                <div class="field field--with-error" style="margin: 5px 0;">
                    <input type="text" name="email" id="email" value="{{ data_get($AUTHENTICATED_USER, 'email') }}" class="field__input" autocomplete="phone" placeholder="E-mail">
                    <label class="field__label" for="email">E-mail <span aria-hidden="true"> (không yêu cầu nhập)</span></label>
                </div>
            </div>

            <div class="form-group">
                <div class="field field--with-error" style="margin: 5px 0;">
                    <input type="text" name="phone_number" id="phone_number" value="{{ data_get($AUTHENTICATED_USER, 'phone_number') }}" class="field__input" autocomplete="phone" value aria-required="true" required placeholder="Số Điện Thoại / Email">
                    <label class="field__label" for="phone_number">Số điện thoại <span aria-hidden="true">*</span></label>
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
