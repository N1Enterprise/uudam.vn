@extends('backoffice.layouts.master')

@php
	$title = ('Chỉnh sửa quản trị viên');

	$breadcrumbs = [
        [
			'label' => __('Quản trị viên'),
        ],
		[
			'label' => $title,
		]
	];
@endphp

@section('header')
{{ __($title) }}
@endsection

@component('backoffice.partials.breadcrumb', ['items' => $breadcrumbs]) @endcomponent

@section('content_body')
<div class="k-content__body	k-grid__item k-grid__item--fluid" id="k_content_body">
    <div class="row">
        <div class="col-md-12">
            <!--begin::Portlet-->
            <div class="k-portlet">
                <div class="k-portlet__head">
                    <div class="k-portlet__head-label">
                        <h3 class="k-portlet__head-title">{{ __('Thông tin quản trị viên') }}</h3>
                    </div>
                </div>

                <!--begin::Form-->
                <form id="form_update-admin" class="k-form" method="post" action="{{ route('bo.web.admins.update', $admin->getKey()) }}">
                    @method('PUT')
                    @csrf
                    <div class="k-portlet__body">
                        @include('backoffice.partials.message')
                        <div class="form-group">
                            <label>{{ __('Email') }} *</label>
                            <input type="text" disabled class="form-control" name="email" placeholder="{{ __('Enter email') }}" value="{{ $admin->email }}" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Tên') }} *</label>
                            <input type="text" class="form-control"  name="name" placeholder="{{ __('Nhập tên') }}" value="{{ old('name', $admin->name) }}" required>
                        </div>
                        @if (is_webmaster())
                        <div class="form-group">
                            <label>{{ __('Roles') }} * <div class="invalid-feedback">{{__('Chọn role')}}</div></label>
                            <div class="k-checkbox-list">
                                @foreach($roles as $role)
                                <label class="k-checkbox k-checkbox--success">
                                    <input class="roles" name="roles[{{ $role->id }}]" type="checkbox" {{ $admin->hasRole($role->id) ? 'checked' : '' }}> {{ $role->name }}
                                    <span></span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if ($admin->id == $AUTHENTICATED_ADMIN->id || is_webmaster())
                        <div class="form-group">
                            <label>{{ __('Password') }}</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password" id="password" placeholder="{{ __('Enter password') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" id="random-password" type="button">{{ __('Random Password') }}</button>
                                </div>
                            </div>
                            <span class="form-text text-muted">{{ __('Để trống trường mật khẩu để giữ mật khẩu hiện tại của bạn.') }}</span>
                        </div>
                        @endif
                    </div>
                    <div class="k-portlet__foot">
                        <div class="k-form__actions">
                            <button type="submit" class="btn btn-primary">{{ __('Lưu') }}</button>
                            <button type="redirect" class="btn btn-secondary">{{ __('Huỷ') }}</button>
                            @if(is_webmaster())
                            <a class="btn btn-danger float-right actionBtn mr-2" data-method="put" data-confirmable="{{ __('Are you sure you want to deactivate this user?') }} " href="{{ route('bo.web.admins.deactivate', $admin->getKey()) }}">{{ __('Vô hiệu hóa') }}</a>
                            <a class="btn btn-primary float-right actionBtn mr-2" data-method="put" data-confirmable="{{ __('Are you sure you want to active this user?') }} " href="{{ route('bo.web.admins.active', $admin->getKey()) }}">{{ __('Hoạt động') }}</a>
                            @endif
                        </div>
                    </div>
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
</div>
@endsection

@section('js_script')
@include('backoffice.pages.admins.js-pages.edit-script')
@endsection
