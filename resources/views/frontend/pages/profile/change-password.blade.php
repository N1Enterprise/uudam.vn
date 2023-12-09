@extends('frontend.layouts.profile')

@section('page_title')
Thay đổi mật khẩu | {{ config('app.user_domain') }}
@endsection

@section('page_seo')
<meta property="og:title" content="Thay đổi mật khẩu | {{ config('app.user_domain') }}">
<meta property="og:description" content="Thay đổi mật khẩu | {{ config('app.user_domain') }}">
<meta property="og:url" content="{{ request()->url() }}">
<meta property="og:site_name" content="{{ config('app.user_domain') }} }}">
<meta property="og:type" content="website">
<meta property="og:locale" content="vi_VN">
<meta property="og:price:currency" content="VND">
<meta name="al:ios:app_name" content="{{ data_get($PAGE_SETTINGS, 'app_name') }}">
<meta name="al:iphone:app_name" content="{{ data_get($PAGE_SETTINGS, 'app_name') }}">
<meta name="al:ipad:app_name" content="{{ data_get($PAGE_SETTINGS, 'app_name') }}">
@endsection

@section('profile_content')
<div class="profile-change-password">
    <h4>Thay đổi mật khẩu</h4>
    <form action="{{ route('fe.api.user.update-password') }}" method="POST" data-form="change-password">
        <div class="form-fields">

            <div class="form-group">
                <div class="field field--with-error" style="margin: 5px 0;">
                    <input type="text" name="password" id="password" class="field__input" autocomplete="phone" value aria-required="true" required placeholder="password">
                    <label class="field__label" for="password">Mật khẩu <span aria-hidden="true">*</span></label>
                </div>
            </div>

            <button type="submit" class="button" style="display: block; width: 100%; margin-bottom: 5px;" data-button-submit-text>Lưu thay đổi</button>
        </div>
        </div>
    </form>
</div>
@endsection

@section('profile_js')
<script src="{{ asset_with_version('frontend/bundle/js/profile/change-password.min.js') }}"></script>
@endsection
