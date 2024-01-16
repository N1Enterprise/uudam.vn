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
<meta name="al:ios:app_name" content="{{ data_get($SYSTEM_SETTING, 'page_settings.app_name') }}">
<meta name="al:iphone:app_name" content="{{ data_get($SYSTEM_SETTING, 'page_settings.app_name') }}">
<meta name="al:ipad:app_name" content="{{ data_get($SYSTEM_SETTING, 'page_settings.app_name') }}">
@endsection

@section('profile_content')
<div class="profile-new-address">
    <h4>Chỉnh sửa địa chỉ</h4>
    <div class="address-list">
        
    </div>
</div>
@endsection
