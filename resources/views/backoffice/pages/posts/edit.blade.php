@extends('backoffice.layouts.master')

@php
	$title = __('Chỉnh sửa bài viết');

	$breadcrumbs = [
		[
			'label' => __('Bài viết'),
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
						<h3 class="k-portlet__head-title">{{ __('Thông tin bài viết') }}</h3>
					</div>
					<div class="k-portlet__head-toolbar">
						<ul class="nav nav-tabs nav-tabs-bold nav-tabs-line nav-tabs-line-brand">
							<li class="nav-item">
								<a class="nav-link active show" data-toggle="tab" href="#mainTab">
									{{ __('Thông tin chung') }}
								</a>
							</li>

                            <li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#linkTab">
									{{ __('Thông tin liên kết') }}
								</a>
							</li>
						</ul>
					</div>
				</div>

				<!--begin::Form-->
				<form class="k-form" name="form_posts" id="form_posts" method="post" action="{{ route('bo.web.posts.update', $post->id) }}" enctype="multipart/form-data">
					@csrf
                    @method('PUT')
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="tab-content">
							<div class="tab-pane active show" id="mainTab">
                                <div class="form-group">
                                    <label for="">{{ __('Xem chi tiết') }} *</label>

                                    <div>
                                        <a href="{{ route('fe.web.posts.index', ['slug' => data_get($post, 'slug'), 'code' => data_get($post, 'code')]) }}" target="_blank">
                                            {{ route('fe.web.posts.index', ['slug' => data_get($post, 'slug'), 'code' => data_get($post, 'code')]) }}
                                        </a>

                                        <button type="button" data-copy-clipboard data-copy-clipboard-content="{{ route('fe.web.posts.index', ['slug' => data_get($post, 'slug'), 'code' => data_get($post, 'code')]) }}" class="btn btn-sm btn-outline-primary ml-2">{{ __('COPY') }}</button>
                                    </div>
                                </div>

								<div class="form-group">
									<label>{{ __('Tên') }} *</label>
									<input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" placeholder="{{ __('Nhập tên') }}" value="{{ old('name', $post->name) }}" data-reference-slug="slug" required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
								</div>

                                <div class="form-group">
									<label>{{ __('Đường dẫn') }} *</label>
									<input type="text" class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" name="slug" placeholder="{{ __('Nhập [SEO] tiêu đề') }}" value="{{ old('slug', $post->slug) }}" required>
                                    @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
								</div>

                                <div class="form-group">
									<label>{{ __('Người viết') }}</label>
									<input type="text" class="form-control {{ $errors->has('author') ? 'is-invalid' : '' }}" name="author" placeholder="{{ __('Nhập tên') }}" value="{{ old('author', $post->author) }}">
                                    @error('author')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
								</div>

                                <div class="form-group">
                                    <label for="">{{ __('Code') }} *</label>
                                    <div class="input-group">
                                        <input id="code" type="text" name="code" value="{{ old('code', $post->code) }}" class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" placeholder="{{ __('Nhập Code') }}" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" data-generate data-generate-length="5" data-generate-ref="#code" data-generate-uppercase="true" type="button">{{ __('Generate Code') }}</button>
                                        </div>
                                    </div>

                                    @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Danh mục') }} *</label>
                                    <select name="post_category_id" title="-- {{ __('Chọn danh mục') }} --" data-toggle="tooltip" data-live-search="true" class="form-control k_selectpicker {{ $errors->has('post_category_id') ? 'is-invalid' : '' }}" required>
                                        @foreach($postCategories as $category)
                                        <option value="{{ $category->id }}" {{ old('post_category_id', $post->post_category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('post_category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
									<label>{{ __('Thứ tự') }}</label>
									<input type="number" class="form-control {{ $errors->has('order') ? 'is-invalid' : '' }}" name="order" placeholder="{{ __('Nhập thứ tự ưu tiên') }}" value="{{ old('order', $post->order) }}">
                                    @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
								</div>

                                <div class="form-group">
                                    <label>{{ __('Hình ảnh') }} *</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="upload_image_custom position-relative">
                                                <input type="text" data-image-ref-path="primary" data-image-ref-index="0" class="form-control image_primary_image_url" name="image[path]" value="{{ old('image.path', $post->image) }}" placeholder="{{ __('Tải ảnh lên hoặc nhập URL ảnh') }}" style="padding-right: 104px;">
                                                <div data-image-ref-wrapper="primary" data-image-ref-index="0" class="d-none w-100 position-absolute d-none" style="top: 50%; left: 4px; transform: translateY(-50%); height: 90%; background-color: #fff;">
                                                    <div class="d-flex align-items-center h-100">
                                                        <img data-image-ref-img="primary" data-image-ref-index="0" src="" alt="Image preview" class="mr-2" style="height: 100%; width: 100px;">
                                                        <span data-image-ref-delete="primary" data-image-ref-index="0" style="font-size: 16px; cursor: pointer;">&times;</span>
                                                    </div>
                                                </div>
                                                <label for="image_primary_image" class="btn position-absolute btn-secondary upload_image_custom_append_icon btn-sm d-flex">
                                                    <input type="file" id="image_primary_image" data-image-ref-path="file" data-image-ref-index="0" name="image[file]" class="d-none image_primary_image_file">
                                                    <i class="flaticon2-image-file"></i>
                                                    <span>{{ __('Tải lên') }}</span>
                                                </label>
                                            </div>
                                            <input type="hidden" class="form-control @anyerror('image, image.file,image.path') is-invalid @endanyerror">
                                            @anyerror('image, image.file, image.path')
                                            {{ $displayMessages() }}
                                            @endanyerror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="image_primary_image_review">
                                                <div data-image-ref-review-wrapper="primary" data-image-ref-index="0" class="d-none" style="width: 100px; height: 100px; border: 1px solid #ccc;">
                                                    <img data-image-ref-review-img="primary" data-image-ref-index="0" style="width: 100%; height: 100%;" src="" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="">{{ __('Mô tả') }}</label>
                                    <textarea name="description" id="" rows="3" class="form-control">{{ old('description', $post->description) }}</textarea>
                                </div>

                                <div class="form-group">
                                    <x-content-editor id="post_content" label="Content" name="content" value="{{ old('content', $post->content) }}" />
                                </div>

                                <div class="form-group">
                                    <label for="">{{ __('Được viết lúc') }}</label>
                                    <input
                                        type="datetimepicker"
                                        class="form-control @error('post_at') is-invalid @enderror"
                                        name="post_at"
                                        value="{{ old('post_at', data_get($post, 'post_at', now())) }}"
                                    >
                                </div>

                                <div class="form-group">
									<label>{{ __('[SEO] Tiêu đề') }}</label>
									<input type="text" class="form-control {{ $errors->has('meta_title') ? 'is-invalid' : '' }}" name="meta_title" placeholder="{{ __('Nhập [SEO] tiêu đề') }}" value="{{ old('meta_title', $post->meta_title) }}">
                                    @error('meta_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
								</div>

                                <div class="form-group">
									<label>{{ __('[SEO] Mô tả') }}</label>
									<input type="text" class="form-control {{ $errors->has('meta_description') ? 'is-invalid' : '' }}" name="meta_description" placeholder="{{ __('Nhập [SEO] mô tả') }}" value="{{ old('meta_description', $post->meta_description) }}">
                                    @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
								</div>

                                <div class="form-group row">
									<label class="col-2 col-form-label">{{ __('Hiển thị FE') }}</label>
									<div class="col-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ old('display_on_frontend', boolean($post->display_on_frontend)) == '1'  ? 'checked' : ''}} value="1" name="display_on_frontend" />
												<span></span>
											</label>
										</span>
									</div>
								</div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">{{ __('Tìm kiếm FE') }}</label>
                                    <div class="col-3">
                                        <span class="k-switch">
                                            <label>
                                                <input type="checkbox" {{ old('allow_frontend_search',  boolean($post->allow_frontend_search)) == '1'  ? 'checked' : '' }} value="1" name="allow_frontend_search"/>
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
												<input type="checkbox" {{ old('status', boolean($post->status)) == '1'  ? 'checked' : ''}} value="1" name="status"/>
												<span></span>
											</label>
										</span>
									</div>
								</div>
							</div>

                            <div class="tab-pane" id="linkTab">
                                <div class="form-group">
                                    <label>{{ __('Sản phẩm liên kết') }}</label>
                                    <select data-actions-box="true" name="linked_products[]" title="-- {{ __('Sản phẩm liên kết') }} --" data-size="5" data-live-search="true" class="form-control k_selectpicker Related_Product_Linked_Selector" multiple data-selected-text-format="count > 5">
                                        @foreach($products as $product)
                                        <option
                                            {{ in_array($product->id, old('linked_products', $post->linkedProducts->pluck('id')->toArray())) ? 'selected' : '' }}
                                            data-tokens="{{ $product->id }} | {{ $product->name }} | {{ $product->code }}"
                                            data-subtext="[{{ $product->id }}-{{ $product->code }}]"
                                            data-product-id="{{ $product->id }}"
                                            data-product-name="{{ $product->name }}"
                                            value="{{ $product->id }}"
                                        >{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="form-group Related_Product_Linked_Allowed_Holder mb-0 mt-2">
                                        <div class="Related_Product_Linked_Holder_Content"></div>
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
@include('backoffice.pages.posts.js-pages.handle')
@include('backoffice.pages.posts.js-pages.products-linked')
@endsection
