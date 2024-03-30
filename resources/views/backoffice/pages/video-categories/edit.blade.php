@extends('backoffice.layouts.master')

@php
	$title = __('Cập nhật danh mục video');

	$breadcrumbs = [
		[
			'label' => __('Danh mục video'),
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
		<div class="col-md-6">

			<!--begin::Portlet-->
			<div class="k-portlet k-portlet--tabs">
				<div class="k-portlet__head">
					<div class="k-portlet__head-label">
						<h3 class="k-portlet__head-title">{{ __('Thông tin danh mục video') }}</h3>
					</div>
					<div class="k-portlet__head-toolbar">
						<ul class="nav nav-tabs nav-tabs-bold nav-tabs-line nav-tabs-line-brand" role="tablist">
							<li class="nav-item">
								<a class="nav-link active show" data-toggle="tab" href="#mainTab" role="tab">
									{{ __('Thông tin chung') }}
								</a>
							</li>
						</ul>
					</div>
				</div>

				<!--begin::Form-->
				<form class="k-form" name="form-video-category" id="form-video-category" method="POST" action="{{ route('bo.web.video-categories.update', $videoCategory->id) }}">
					@csrf
					@method('PUT')
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="tab-content">
							<div class="tab-pane active show" id="mainTab" role="tabpanel">
                                <div class="form-group">
									<label>{{ __('Tên') }} *</label>
									<input type="text" class="form-control" name="name" placeholder="{{ __('Nhập tên') }}" value="{{ old('name', $videoCategory->name) }}" data-reference-slug="slug" required>
								</div>

								<div class="form-group">
									<label for="">{{ __('Đường dẫn') }} *</label>
									<input type="text" name="slug" class="form-control" value="{{ old('slug', $videoCategory->slug) }}" required>
								</div>

								<div class="form-group">
									<label>{{ __('Thứ tự') }}</label>
									<input type="number" class="form-control" name="order" placeholder="{{ __('Nhập thứ tự ưu tiên') }}" value="{{ old('order', $videoCategory->order) }}">
								</div>

								<div class="form-group row">
									<label class="col-2 col-form-label">{{ __('Hoạt động') }}</label>
									<div class="col-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ boolean(old('status', $videoCategory->status)) ? 'checked' : ''}} value="1" name="status" />
												<span></span>
											</label>
										</span>
									</div>
								</div>

								<div class="row">
									<div class="col-2">
										<label class="col-form-label">{{ __('FE Hiển thị') }}</label>
									</div>
									<div class="col-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ old('display_on_frontend', $videoCategory->display_on_frontend) == '1'  ? 'checked' : ''}} value="1" name="display_on_frontend"/>
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
