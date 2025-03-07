@extends('backoffice.layouts.master')

@php
	$title = __('Tạo banner');

	$breadcrumbs = [
        [
			'label' => __('Banner'),
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

@section('style')
<style>
    .upload_image_custom_append_icon {
        top: 50%;
        right: 0;
        transform: translate(-6%, -50%);
        color: #4346ce!important;
        border: 1px solid #4346ce!important;
    }
    .note-toolbar-wrapper.panel-default {
        margin-bottom: 10px!important;
    }
    #form_builder_dom.styled {
        padding: 10px 35px;
        border: 1px solid #ebedf2;
        border-radius: 3px;
    }
    .ce-block__content,
    .ce-toolbar__content {
        max-width: unset!important;
    }
    .codex-editor__redactor {
        padding-bottom: 0px!important;
        min-height: 200px;
    }
</style>
@endsection

@section('content_body')
<div class="k-content__body	k-grid__item k-grid__item--fluid" id="k_content_body">
	<div class="row">
		<div class="col-md-12">

			<!--begin::Portlet-->
			<div class="k-portlet k-portlet--tabs">
				<div class="k-portlet__head">
					<div class="k-portlet__head-label">
						<h3 class="k-portlet__head-title">{{ __('Thông tin banner') }}</h3>
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
				<form class="k-form" name="form_category_group" id="form_category_group" method="post" action="{{ route('bo.web.banners.store') }}" enctype="multipart/form-data">
					@csrf
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="tab-content">
							<div class="tab-pane active show" id="mainTab">
								<div class="form-group">
									<label>{{ __('Tên') }} *</label>
									<input type="text" class="form-control" name="name" placeholder="{{ __('Nhập tên') }}" value="{{ old('name') }}" required>
								</div>

                                <div class="form-group">
									<label>{{ __('Nhãn') }}</label>
									<input type="text" class="form-control" name="label" placeholder="{{ __('Nhập nhãn') }}" value="{{ old('label') }}">
								</div>

                                <div class="form-group">
                                    <label>{{ __('Loại hiển thị') }} *</label>
                                    <select name="type" title="-- {{ __('Chọn loại hiển thị') }} --" class="form-control k_selectpicker" required>
                                        @foreach ($bannerTypeEnumLabels as $key => $label)
                                        <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
									<label>{{ __('Nhãn CTA') }}</label>
									<input type="text" class="form-control" name="cta_label" placeholder="{{ __('Nhập nhãn Cta') }}" value="{{ old('cta_label') }}">
								</div>

                                <div class="form-group">
									<label>{{ __('Chuyển hướng URL') }}</label>
									<input type="text" class="form-control" name="redirect_url" placeholder="{{ __('Nhập chuyển hướng url') }}" value="{{ old('redirect_url') }}">
								</div>

                                <div class="form-group">
									<label>{{ __('Thứ tự') }}</label>
									<input type="number" class="form-control" name="order" placeholder="{{ __('Nhập thứ tự ưu tiên') }}" value="{{ old('order') }}">
								</div>

                                <div class="form-group">
									<label>{{ __('Màu sắc') }}</label>
									<input type="color" class="form-control p-1" name="color" placeholder="{{ __('Nhập màu sắc') }}" value="{{ old('color') }}">
								</div>

                                <div class="form-group">
                                    <label>{{ __('Ảnh Desktop') }} *</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="upload_image_custom position-relative">
                                                <input type="text" data-image-ref-path="desktop" data-image-ref-index="0" class="form-control image_desktop_image_url" name="desktop_image[path]" value="{{ old('desktop_image.path') }}" placeholder="{{ __('Tải ảnh lên hoặc nhập URL ảnh') }}" style="padding-right: 104px;">
                                                <div data-image-ref-wrapper="desktop" data-image-ref-index="0" class="d-none w-100 position-absolute d-none" style="top: 50%; left: 4px; transform: translateY(-50%); height: 90%; background-color: #fff;">
                                                    <div class="d-flex align-items-center h-100">
                                                        <img data-image-ref-img="desktop" data-image-ref-index="0" src="" alt="Image preview" class="mr-2" style="height: 100%; width: 100px;">
                                                        <span data-image-ref-delete="desktop" data-image-ref-index="0" style="font-size: 16px; cursor: pointer;">&times;</span>
                                                    </div>
                                                </div>
                                                <label for="image_desktop_image" class="btn position-absolute btn-secondary upload_image_custom_append_icon btn-sm d-flex">
                                                    <input type="file" id="image_desktop_image" data-image-ref-path="file" data-image-ref-index="0" name="desktop_image[file]" class="d-none image_desktop_image_file">
                                                    <i class="flaticon2-image-file"></i>
                                                    <span>{{ __('Tải lên') }}</span>
                                                </label>
                                            </div>
                                            <input type="hidden" class="form-control @anyerror('desktop_image, desktop_image.file, desktop_image.path') is-invalid @endanyerror">
                                            @anyerror('desktop_image, desktop_image.file, desktop_image.path')
                                            {{ $displayMessages() }}
                                            @endanyerror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="image_desktop_image_review">
                                                <div data-image-ref-review-wrapper="desktop" data-image-ref-index="0" class="d-none" style="width: 100px; height: 100px; border: 1px solid #ccc;">
                                                    <img data-image-ref-review-img="desktop" data-image-ref-index="0" style="width: 100%; height: 100%;" src="" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Ảnh Mobile') }}</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="upload_image_custom position-relative">
                                                <input type="text" data-image-ref-path="mobile" data-image-ref-index="0" class="form-control image_mobile_image_url" name="mobile_image[path]" value="{{ old('mobile_image.path') }}" placeholder="{{ __('Tải ảnh lên hoặc nhập URL ảnh') }}" style="padding-right: 104px;">
                                                <div data-image-ref-wrapper="mobile" data-image-ref-index="0" class="d-none w-100 position-absolute d-none" style="top: 50%; left: 4px; transform: translateY(-50%); height: 90%; background-color: #fff;">
                                                    <div class="d-flex align-items-center h-100">
                                                        <img data-image-ref-img="mobile" data-image-ref-index="0" src="" alt="Image preview" class="mr-2" style="height: 100%; width: 100px;">
                                                        <span data-image-ref-delete="mobile" data-image-ref-index="0" style="font-size: 16px; cursor: pointer;">&times;</span>
                                                    </div>
                                                </div>
                                                <label for="image_mobile_image" class="btn position-absolute btn-secondary upload_image_custom_append_icon btn-sm d-flex">
                                                    <input type="file" id="image_mobile_image" data-image-ref-path="file" data-image-ref-index="0" name="mobile_image[file]" class="d-none image_mobile_image_file">
                                                    <i class="flaticon2-image-file"></i>
                                                    <span>{{ __('Tải lên') }}</span>
                                                </label>
                                            </div>
                                            <input type="hidden" class="form-control @anyerror('mobile_image, mobile_image.file, mobile_image.path') is-invalid @endanyerror">
                                            @anyerror('mobile_image, mobile_image.file, mobile_image.path')
                                            {{ $displayMessages() }}
                                            @endanyerror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="image_mobile_image_review">
                                                <div data-image-ref-review-wrapper="mobile" data-image-ref-index="0" class="d-none" style="width: 100px; height: 100px; border: 1px solid #ccc;">
                                                    <img data-image-ref-review-img="mobile" data-image-ref-index="0" style="width: 100%; height: 100%;" src="" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="">{{ __('Mô tả') }}</label>
                                    <textarea name="description" id="" rows="3" class="form-control">{{ old('description') }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">{{ __('Ngày bắt đầu') }} *</label>
                                            <input type="datetimepicker" class="form-control @error('start_at') is-invalid @enderror" name="start_at" value="{{ old('start_at', now()) }}" required>
                                            @error('start_at')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">{{ __('Ngày kết thúc') }}</label>
                                            <input type="datetimepicker" class="form-control @error('end_at') is-invalid @enderror" name="end_at" value="{{ old('end_at') }}">
                                            @error('end_at')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
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

@section('js_script')
@include('backoffice.pages.banners.js-pages.handle')
@endsection
