@extends('frontend.layouts.profile')

@section('page_title')
Quản lí địa chỉ | {{ config('app.user_domain') }}
@endsection

@section('page_seo')
{!! generate_seo_html(['page_name' => 'Quản lí địa chỉ']) !!}
@endsection

@section('profile_style')
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/pages/profile.min.css') }}">
@endsection

@section('profile_content')
<div class="profile-new-address">
    <h4>Sổ địa chỉ</h4>
    <div class="address-list">
        <a href="{{ route('fe.web.user.localization.address.create') }}" class="new-address-btn">
            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>
            </svg>
            <span>Thêm địa chỉ mới</span>
        </a>
        @if (has_data($addresses))
            @foreach ($addresses as $address)
            <div class="address-item">
                <div class="info">
                    <div class="name">
                        <div>{{ data_get($address, 'name') }}</div>
                        @if (data_get($address, 'is_default'))
                        <span>
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path d="M256 8C119.033 8 8 119.033 8 256s111.033 248 248 248 248-111.033 248-248S392.967 8 256 8zm0 48c110.532 0 200 89.451 200 200 0 110.532-89.451 200-200 200-110.532 0-200-89.451-200-200 0-110.532 89.451-200 200-200m140.204 130.267l-22.536-22.718c-4.667-4.705-12.265-4.736-16.97-.068L215.346 303.697l-59.792-60.277c-4.667-4.705-12.265-4.736-16.97-.069l-22.719 22.536c-4.705 4.667-4.736 12.265-.068 16.971l90.781 91.516c4.667 4.705 12.265 4.736 16.97.068l172.589-171.204c4.704-4.668 4.734-12.266.067-16.971z"></path>
                            </svg>
                            <span>Địa chỉ mặc định</span>
                        </span>
                        @endif
                    </div>
                    <div class="address">
                        <span>Địa chỉ: </span>{{ data_get($address, 'full_address') }}
                    </div>
                    <div class="phone">
                        <span>Điện thoại: </span>{{ data_get($address, 'phone') }}
                    </div>
                    @if (data_get($address, 'email'))
                    <div class="phone">
                        <span>E-mail: </span>{{ data_get($address, 'email') }}
                    </div>
                    @endif
                </div>
                <div class="action">
                    <div>
                        <a class="edit" href="{{ route('fe.web.user.localization.address.edit', data_get($address, 'code')) }}" style="display: block; text-align: right; font-size: 12px;">Chỉnh sửa</a>
                        @if (!data_get($address, 'is_default'))
                        <a class="mark-as-default-address" data-method="PUT" href="{{ route('fe.api.user.address.mark-as-default', data_get($address, 'code')) }}" style="display: block; text-align: right; font-size: 12px;">Đặt làm mặt định</a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
</div>

@include('frontend.pages.checkouts.partials.modal-address')
@endsection

@section('profile_js')
<script src="{{ asset_with_version('frontend/bundle/js/address.min.js') }}" type="text/javascript"></script>
@endsection
