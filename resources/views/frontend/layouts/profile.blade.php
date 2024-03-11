@extends('frontend.layouts.master')

@section('style')
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/profile-index.min.css') }}">
@yield('profile_style')
@endsection

@section('content_body')
<section class="shopify-section section page-width">
    <div class="profile-tabs customer account" style="margin-top: 20px;">
        <nav class="profile-tabs-nav">
            <a href="{{ route('fe.web.user.profile') }}" class="profile-tabs-nav__tab">Tài khoản</a>
            <a href="{{ route('fe.web.user.security.password-change') }}" class="profile-tabs-nav__tab">Mật khẩu</a>
            <a href="{{ route('fe.web.user.profile.order-histories') }}" class="profile-tabs-nav__tab">Đơn hàng</a>
            <a href="{{ route('fe.web.user.localization.address') }}" class="profile-tabs-nav__tab">Sổ địa chỉ</a>
        </nav>
        <div class="profile-tabs-content">
            @yield('profile_content')
        </div>
    </div>
</section>
@endsection

@section('js_script')
<script>
    $(document).ready(function() {
        const currentUrl = window.location.href.match(/^(https?:\/\/[^/]+\/bo\/[^/]+)\/?/)?.[1] || window.location.href;
        const urlPaths = window.location.pathname.split('/').filter(path => path);

        $.each($('.profile-tabs-nav__tab'), function(index, element) {
            const linkHref = $(element).attr('href');

            let isActive = (new URL(linkHref)).pathname.split('/').filter(path => (path))[0] == urlPaths[0];

            if( isActive) {
                $(element).addClass('active');
                return false;
            }
        });
    });
</script>

@yield('profile_js')
@endsection
