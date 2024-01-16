@extends('frontend.layouts.master')

@section('style')
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/profile-index.min.css') }}">
@yield('profile_style')
@endsection

@section('content_body')
<section class="shopify-section section page-width">
    <div class="profile-tabs customer account" style="margin-top: 20px;">
        <nav class="profile-tabs-nav">
            <a href="{{ route('fe.web.user.profile.info') }}" class="profile-tabs-nav__tab">Tài khoản</a>
            <a href="{{ route('fe.web.user.profile.password-change') }}" class="profile-tabs-nav__tab">Mật khẩu</a>
            <a href="{{ route('fe.web.user.profile.order-histories') }}" class="profile-tabs-nav__tab">Đơn hàng</a>
            <a href="{{ route('fe.web.user.profile.address') }}" class="profile-tabs-nav__tab">Sổ địa chỉ</a>
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
        const pathname = window.location.pathname;

        $.each($('.profile-tabs-nav__tab'), function(index, element) {
            const href = $(element).attr('href');

            $(element).toggleClass('active', href.includes(pathname));
        });
    });
</script>

@yield('profile_js')
@endsection
