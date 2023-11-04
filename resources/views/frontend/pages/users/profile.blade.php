@extends('frontend.layouts.master')

@push('style_pages')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/pages/profile/index.css') }}">
@endpush

@section('content_body')
<section class="shopify-section section">
    <div class="customer account">
        <div>
            <h1>Thông tin tài khoản</h1>
            <a href="{{ route('fe.api.user.signout') }}" id="User_SignOut">
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" fill="none" viewBox="0 0 18 19">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6 4.5a3 3 0 116 0 3 3 0 01-6 0zm3-4a4 4 0 100 8 4 4 0 000-8zm5.58 12.15c1.12.82 1.83 2.24 1.91 4.85H1.51c.08-2.6.79-4.03 1.9-4.85C4.66 11.75 6.5 11.5 9 11.5s4.35.26 5.58 1.15zM9 10.5c-2.5 0-4.65.24-6.17 1.35C1.27 12.98.5 14.93.5 18v.5h17V18c0-3.07-.77-5.02-2.33-6.15-1.52-1.1-3.67-1.35-6.17-1.35z" fill="currentColor"></path>
                </svg>
                Đăng xuất
            </a>
        </div>
        <div>
            <div>
                <h2>Lịch sử mua hàng</h2>
                <p>Bạn chưa đặt bất kỳ đơn đặt hàng nào.</p>
            </div>
            <div>
                <h2>Chi tiết tài khoản</h2>
                <div>
                    <p>Tên đăng ký: {{ $user->name }}</p>
                    <p>E-mail: {{ $user->email }}</p>
                    <p>Số điện thoại: {{ $user->phone_number }}</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
