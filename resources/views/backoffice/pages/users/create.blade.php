@extends('backoffice.layouts.master')

@php
    $title = __('Tạo khách hàng');

    $breadcrumbs = [
        [
            'label' => __('Danh sách khách hàng'),
        ],
        [
            'label' => $title,
        ],
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
			<div class="k-portlet k-portlet--tabs">
				<div class="k-portlet__head">
					<div class="k-portlet__head-label">
						<h3 class="k-portlet__head-title">{{ __('Tạo khách hàng mới') }}</h3>
					</div>
					<div class="k-portlet__head-toolbar">
						<ul class="nav nav-tabs nav-tabs-bold nav-tabs-line nav-tabs-line-brand">
							<li class="nav-item">
								<a class="nav-link active show" data-toggle="tab" href="#mainTab">
									{{ __('Thông tin chung') }}
								</a>
							</li>
						</ul>
					</div>
				</div>

				<!--begin::Form-->
				<form class="k-form" name="form_users" id="form_users" method="post" action="{{ route('bo.web.users.store') }}">
					@csrf
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="tab-content">
							<div class="tab-pane active show" id="mainTab">
								<div class="form-group">
                                    <label for="">{{ __('Tên tài khoản') }} *</label>
                                    <div class="input-group">
                                        <input id="username" type="text" name="username" value="{{ old('username') }}" class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" placeholder="{{ __('Nhập tên tài khoản') }}" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" data-generate data-generate-length="10" data-generate-ref="#username" data-generate-lowercase="true" type="button">{{ __('Generate username') }}</button>
                                        </div>
                                    </div>

                                    @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
									<label>{{ __('Tên hiển thị') }} *</label>
									<input type="text" class="form-control" name="name" placeholder="{{ __('Nhập tên') }}" value="{{ old('name') }}" required>
								</div>

                                <div class="form-group">
                                    <label>{{ __('Mã tiền tệ') }} *</label>
                                    <select name="currency_code" data-live-search="true" class="form-control k_selectpicker  {{ $errors->has('currency_code') ? 'is-invalid' : '' }}" required>
                                        @foreach($currencies as $currency)
                                        <option value="{{ $currency->code }}" {{ old('currency_code') == $currency->code ? 'selected' : '' }}>{{ $currency->name }} ({{ $currency->code }})</option>
                                        @endforeach
                                    </select>
                                    @error('currency_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
									<label>{{ __('E-mail') }}</label>
									<input type="text" class="form-control" name="email" placeholder="{{ __('Nhập e-mail') }}" value="{{ old('email') }}" required>
								</div>

                                <div class="form-group">
									<label>{{ __('Số điện thoại') }}</label>
									<input type="text" class="form-control" name="phone_number" placeholder="{{ __('Nhập số điện thoại') }}" value="{{ old('phone_number') }}" required>
								</div>

                                <div class="form-group">
                                    <label for="">{{ __('Ngày sinh nhật') }}</label>
                                    <input type="datetimepicker" class="form-control @error('birthday') is-invalid @enderror" name="birthday" value="{{ old('birthday') }}">
                                </div>

                                <div class="form-group">
                                    <label for="">{{ __('Mật khẩu') }}</label>
                                    <div class="input-group">
                                        <input id="password" type="text" name="password" value="{{ old('password') }}" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="{{ __('Nhập mật khẩu') }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" data-generate data-generate-length="10" data-generate-ref="#password" data-generate-lowercase="true" type="button">{{ __('Generate password') }}</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Kênh truy cập') }} *</label>
                                    <select name="access_channel_type" data-live-search="true" class="form-control k_selectpicker  {{ $errors->has('access_channel_type') ? 'is-invalid' : '' }}" required>
                                        @foreach($accessChannelTypeLables as $key => $label)
                                        <option value="{{ $key }}" {{ old('access_channel_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('access_channel_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="">{{ __('Reference kênh truy cập') }}</label>
                                    <input type="text" class="form-control" name="meta[access_channel][reference_id]" placeholder="{{ __('Nhập reference kênh truy cập') }}" value="{{ old('meta.access_channel.reference_id') }}">
                                </div>

                                <div class="form-group row">
									<label class="col-2 col-form-label">{{ __('Người dùng thử nghiệp') }}</label>
									<div class="col-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ old('is_test_user', '1') == '1'  ? 'checked' : ''}} value="1" name="is_test_user"/>
												<span></span>
											</label>
										</span>
									</div>
								</div>

                                <div class="form-group row">
									<label class="col-2 col-form-label">{{ __('Cho phép đăng nhập') }}</label>
									<div class="col-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ old('allow_login', '1') == '1'  ? 'checked' : ''}} value="1" name="allow_login"/>
												<span></span>
											</label>
										</span>
									</div>
								</div>

								<div class="form-group row">
									<label class="col-2 col-form-label">{{ __('Hoạt động') }}</label>
									<div class="col-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ old('status', '1') == '1'  ? 'checked' : ''}} value="1" name="status"/>
												<span></span>
											</label>
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="k-portlet__foot">
						<div class="k-form__actions">
							<button type="submit" class="btn btn-primary">{{ __('Lưu') }}</button>
							<button type="redirect" class="btn btn-secondary">{{ __('Huỷ') }}</button>
						</div>
					</div>
				</form>
				<!--end::Form-->
			</div>
		</div>
	</div>
</div>
@endsection
