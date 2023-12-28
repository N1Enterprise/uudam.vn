@extends('frontend.layouts.master')

@section('style')
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/profile-index.min.css') }}">
<style>
    .profile-tabs-nav {
        display: flex;
    }

    .profile-tabs-content form[data-form] {
        margin-top: 20px;
        width: 100%;
    }

    @media screen and (min-width: 750px) {
        .profile-tabs-content form[data-form] {
            width: 50%;
        }
    }

    .profile-tabs-nav .profile-tabs-nav__tab {
        display: block;
        padding: 10px;
        margin: 5px 0;
        text-decoration: auto;
        /* border: 1px solid #000; */
        margin-right: 10px;
    }

    .profile-tabs-nav .profile-tabs-nav__tab:first-child {
        padding-left: 0;
    }

    .profile-tabs-nav .profile-tabs-nav__tab.active {
        text-decoration: underline!important;
    }

    .product-option {
        font-size: 1.4rem;
        word-break: break-all;
        line-height: calc(1 + 0.5 / var(--font-body-scale));
    }
</style>

@yield('profile_style')
@endsection

@section('content_body')
<section class="shopify-section section page-width">
    <div class="profile-tabs customer account" style="margin-top: 20px;">
        <nav class="profile-tabs-nav">
            <a href="{{ route('fe.web.user.profile.info') }}" class="profile-tabs-nav__tab">Thông tin tài khoản</a>
            <a href="{{ route('fe.web.user.profile.order-history') }}" class="profile-tabs-nav__tab">Lịch sử đơn hàng</a>
            <a href="{{ route('fe.web.user.profile.change-password') }}" class="profile-tabs-nav__tab">Thay đổi mật khẩu</a>
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
