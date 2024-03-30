@extends('backoffice.layouts.master')

@php
	$title = __('Tạo video');

	$breadcrumbs = [
		[
			'label' => __('Video'),
		],
		[
			'label' => $title,
		],
	];
@endphp

@section('header')
{{ __($title) }}
@endsection

@section('style')
<style>
	#video_source_container {
		padding: 10px;
		border: 1px solid #e6e5e5;
		border-radius: 3px;
		background-color: #fafafa;
	}
</style>
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
						<h3 class="k-portlet__head-title">{{ __('Thông tin video') }}</h3>
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
				<form class="k-form" name="form-video" id="form-video" method="post" action="{{ route('bo.web.videos.update', $video->id) }}" enctype="multipart/form-data">
					@csrf
					@method('PUT')
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="tab-content">
							<div class="tab-pane active show" id="mainTab" role="tabpanel">
                                <div class="form-group">
									<label>{{ __('Tên') }} *</label>
									<input type="text" class="form-control" name="name" placeholder="{{ __('Nhập tên') }}" value="{{ old('name', $video->name) }}" data-reference-slug="slug" required>
								</div>

								<div class="form-group">
									<label for="">{{ __('Đường dẫn') }} *</label>
									<input type="text" name="slug" class="form-control" value="{{ old('slug', $video->slug) }}" required>
								</div>

								<div class="form-group">
                                    <label>{{ __('Thể loại') }} *</label>
                                    <div class="form-group">
                                        <select name="type" class="form-control k_selectpicker">
                                            @foreach($videoTypeEnumLables as $key => $label)
                                            <option value="{{ $key }}" {{ old('type', $video->type) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

								<div class="form-group">
									<label>{{ __('Thứ tự') }}</label>
									<input type="number" class="form-control" name="order" placeholder="{{ __('Nhập thứ tự ưu tiên') }}" value="{{ old('order', $video->order) }}">
								</div>

								<div class="form-group">
                                    <label>{{ __('Danh mục') }}</label>
                                    <select name="video_category_id" title="-- {{ __('Chọn Danh mục') }} --" data-toggle="tooltip" data-live-search="true" class="form-control k_selectpicker  {{ $errors->has('video_category_id') ? 'is-invalid' : '' }}">
                                        @foreach($videoCategories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('video_category_id', $video->video_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('video_category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

								<div class="form-group">
                                    <label>{{ __('Thumbnail') }} *</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="upload_image_custom position-relative">
                                                <input type="text" data-image-ref-path="thumbnail" data-image-ref-index="0" class="form-control image_thumbnail_url" name="thumbnail[path]" value="{{ old('thumbnail.path', $video->thumbnail) }}" placeholder="{{ __('Tải ảnh lên hoặc nhập URL ảnh') }}" style="padding-right: 104px;">
                                                <div data-image-ref-wrapper="thumbnail" data-image-ref-index="0" class="d-none w-100 position-absolute d-none" style="top: 50%; left: 4px; transform: translateY(-50%); height: 90%; background-color: #fff;">
                                                    <div class="d-flex align-items-center h-100">
                                                        <img data-image-ref-img="thumbnail" data-image-ref-index="0" src="" alt="Image preview" class="mr-2" style="height: 100%; width: 100px;">
                                                        <span data-image-ref-delete="thumbnail" data-image-ref-index="0" style="font-size: 16px; cursor: pointer;">&times;</span>
                                                    </div>
                                                </div>
                                                <label for="image_thumbnail" class="btn position-absolute btn-secondary upload_image_custom_append_icon btn-sm d-flex">
                                                    <input type="file" id="image_thumbnail" data-image-ref-path="file" data-image-ref-index="0" name="thumbnail[file]" class="d-none image_thumbnail_file">
                                                    <i class="flaticon2-image-file"></i>
                                                    <span>{{ __('Tải lên') }}</span>
                                                </label>
                                            </div>
                                            <input type="hidden" class="form-control @anyerror('thumbnail, thumbnail.file, thumbnail.path') is-invalid @endanyerror">
                                            @anyerror('thumbnail, thumbnail.file, thumbnail.path')
                                            {{ $displayMessages() }}
                                            @endanyerror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="image_thumbnail_review">
                                                <div data-image-ref-review-wrapper="thumbnail" data-image-ref-index="0" class="d-none" style="width: 100px; height: 100px; border: 1px solid #ccc;">
                                                    <img data-image-ref-review-img="thumbnail" data-image-ref-index="0" style="width: 100%; height: 100%;" src="" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

								<div class="form-group">
									<label>{{ __('Video Source URL') }} *</label>
									<input type="text" name="source_url" class="form-control" placeholder="{{ __('Source URL') }}" value="{{ old('source_url', $video->source_url) }}">

									<div class="mt-2" id="video_source_container"></div>
								</div>

								<div class="form-group">
									<label>{{ __('Mô tả ngắn') }}</label>
									<textarea name="description" class="form-control" id="description" rows="3">{{ old('description', $video->description) }}</textarea>
                                </div>

								<div class="form-group">
                                    <x-content-editor id="content" label="{{ __('Nội dung') }}" name="content" value="{{ old('content', $video->content) }}" />
                                </div>

								<div class="form-group">
									<label>{{ __('[SEO] Tiêu đề') }}</label>
									<input type="text" class="form-control {{ $errors->has('meta_title') ? 'is-invalid' : '' }}" name="meta_title" placeholder="{{ __('Nhập [SEO] tiêu đề') }}" value="{{ old('meta_title', $video->meta_title) }}">
                                    @error('meta_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
								</div>

                                <div class="form-group">
									<label>{{ __('[SEO] Mô tả') }}</label>
									<input type="text" class="form-control {{ $errors->has('meta_description') ? 'is-invalid' : '' }}" name="meta_description" placeholder="{{ __('Nhập [SEO] mô tả') }}" value="{{ old('meta_description', $video->meta_description) }}">
                                    @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
								</div>

								<div class="form-group row">
									<label class="col-2 col-form-label">{{ __('Hoạt động') }}</label>
									<div class="col-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ old('status', $video->status) == '1'  ? 'checked' : ''}} value="1" name="status"/>
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
												<input type="checkbox" {{ old('display_on_frontend', $video->display_on_frontend) == '1'  ? 'checked' : ''}} value="1" name="display_on_frontend"/>
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
@include('backoffice.pages.videos.js-pages.handle')
@endsection
