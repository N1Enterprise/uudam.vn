@extends('backoffice.layouts.master')

@php
	$title = __('Tạo sản phẩm');

	$breadcrumbs = [
		[
			'label' => __('Sản phẩm'),
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
	<form id="form_store_product" method="POST" action="{{ route('bo.web.products.store') }}" enctype="multipart/form-data">
        @csrf
        @error('*')
        <div class="alert alert-danger fade show" role="alert">
            <div class="alert-text">
                {{ __('Gửi không thành công. Vui lòng kiểm tra lỗi bên dưới.') }}
            </div>
            <div class="alert-close">
                <button type="button" class="close" data-dismiss="alert">
                    <span><i class="la la-close"></i></span>
                </button>
            </div>
        </div>
        @enderror
        <div class="row">
            <div class="col-md-8">
                <div class="k-portlet">
                    <div class="k-portlet__head">
                        <div class="k-portlet__head-label">
                            <h3 class="k-portlet__head-title">{{ __('Thông tin chung') }}</h3>
                        </div>
                    </div>
                    <div class="k-portlet__body">
                        <div class="form-group">
                            <label for="">{{ __('Tên') }} *</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="{{ __('Nhập tên') }}" data-reference-slug="slug" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="">{{ __('Đường dẫn') }} *</label>
                            <input type="text" name="slug" value="{{ old('slug') }}" class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" placeholder="{{ __('Nhập [SEO] tiêu đề') }}" required>
                            @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="">{{ __('Code') }} *</label>
                            <input type="text" name="code" value="{{ old('code') }}" class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" placeholder="{{ __('Nhập Code') }}" required>
                            @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('Hình ảnh') }} *</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="upload_image_custom position-relative">
                                        <input type="text" data-image-ref-path="primary" data-image-ref-index="0" class="form-control image_primary_image_url" name="primary_image[path]" placeholder="{{ __('Tải ảnh lên hoặc nhập URL ảnh') }}" style="padding-right: 104px;">
                                        <div data-image-ref-wrapper="primary" data-image-ref-index="0" class="d-none w-100 position-absolute d-none" style="top: 50%; left: 4px; transform: translateY(-50%); height: 90%; background-color: #fff;">
                                            <div class="d-flex align-items-center h-100">
                                                <img data-image-ref-img="primary" data-image-ref-index="0" src="" alt="Image preview" class="mr-2" style="height: 100%; width: 100px;">
                                                <span data-image-ref-delete="primary" data-image-ref-index="0" style="font-size: 16px; cursor: pointer;">&times;</span>
                                            </div>
                                        </div>
                                        <label for="image_primary_image" class="btn position-absolute btn-secondary upload_image_custom_append_icon btn-sm d-flex">
                                            <input type="file" id="image_primary_image" data-image-ref-path="file" data-image-ref-index="0" name="primary_image[file]" class="d-none image_primary_image_file">
                                            <i class="flaticon2-image-file"></i>
                                            <span>{{ __('Tải lên') }}</span>
                                        </label>
                                    </div>
                                    <input type="hidden" class="form-control @anyerror('primary_image, primary_image.file, primary_image.path') is-invalid @endanyerror">
                                    @anyerror('primary_image, primary_image.file, primary_image.path')
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
                            <label for="">{{ __('Bộ sưu tập ảnh') }}</label>
                            <div class="media_image_repeater">
                                <div data-repeater-list="media[image]">
                                    <div data-repeater-item class="k-repeater__item">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="upload_image_custom position-relative">
                                                    <input type="text" data-image-ref-path="media" data-image-ref-index="0" class="form-control media_image_path" name="path" placeholder="{{ __('Tải ảnh lên hoặc nhập URL ảnh') }}" style="padding-right: 104px;" value="{{ old('primary_image.path') }}">
                                                    <div data-image-ref-wrapper="media" data-image-ref-index="0" class="d-none w-100 position-absolute d-none" style="top: 50%; left: 4px; transform: translateY(-50%); height: 90%; background-color: #fff;">
                                                        <div class="d-flex align-items-center h-100">
                                                            <img data-image-ref-img="media" data-image-ref-index="0" src="" alt="Image preview" class="mr-2" style="height: 100%; width: 100px;">
                                                            <span data-image-ref-delete="media" data-image-ref-index="0" style="font-size: 16px; cursor: pointer;">&times;</span>
                                                        </div>
                                                    </div>
                                                    <label for="media_image_file_0" class="media_image_file_wapper btn position-absolute btn-secondary upload_image_custom_append_icon btn-sm d-flex">
                                                        <input type="file" name="media[image][0][file]" data-image-ref-file="media" data-image-ref-index="0" class="d-none media_image_file" id="media_image_file_0">
                                                        <i class="flaticon2-image-file"></i>
                                                        <span>{{ __('Tải lên') }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-start">
                                                    <div class="image_media_image_review mr-1">
                                                        <div data-image-ref-review-wrapper="media" data-image-ref-index="0" class="d-none" style="width: 100px; height: 100px; border: 1px solid #ccc;">
                                                            <img data-image-ref-review-img="media" data-image-ref-index="0" style="width: 100%; height: 100%;" src="" alt="">
                                                        </div>
                                                    </div>
                                                    <button type="button" data-repeater-delete class="btn btn-secondary btn-icon h-100 mr-2" style="width: 30px!important; height: 30px!important;">
                                                        <i class="la la-close"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="k-separator k-separator--space-sm"></div>
                                    </div>
                                </div>
                                <div class="k-repeater__add-data">
                                    <span data-repeater-create="" class="btn btn-info btn-sm">
                                        <i class="la la-plus"></i> {{ __('Thêm') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">{{ __('Video') }}</label>
                            <div class="video-media-item">
                                <input type="text" name="media[video][0][path]" value="{{ old('media.video.0.path') }}" class="form-control {{ $errors->has('media.video.0.path') ? 'is-invalid' : '' }}" placeholder="{{ __('Nhập đường dẫn video') }}">
                                <input type="hidden" name="media[video][0][order]" value="1">
                            </div>
                        </div>

                        <div class="form-group">
                            <x-content-editor id="description" label="{{ __('Mô tả') }}" name="description" value="{{ old('description') }}" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="k-portlet">
                    <div class="k-portlet__head">
                        <div class="k-portlet__head-label">
                            <h3 class="k-portlet__head-title">{{ __('Thông tin phân loại') }}</h3>
                        </div>
                    </div>
                    <div class="k-portlet__body">
                        <div class="form-group">
                            <label>{{ __('Danh mục') }} *</label>
                            <select name="categories[]" title="-- {{ __('Chọn danh mục') }} --" class="form-control k_selectpicker" data-size="5" multiple required data-live-search="true">
                                @foreach($categoryGroups as $categoryGroup)
                                <optgroup label="{{ $categoryGroup->name }}">
                                    @foreach($categoryGroup->categories as $category)
                                    <option value="{{ $category->id }}" {{ in_array($category->id, old('categories', [])) ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </optgroup>
                                @endforeach
                            </select>
                            @error('categories')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('Loại sản phẩm') }} *</label>
                            <select name="type" title="-- {{ __('Chọn loại sản phẩm') }} --" class="form-control k_selectpicker">
                                @foreach($productTypeLabels as $key => $label)
                                <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('Thương hiệu') }}</label>
                            <input type="text" class="form-control {{ $errors->has('branch') ? 'is-invalid' : '' }}" name="branch" placeholder="{{ __('Nhập tên thương hiệu') }}" value="{{ old('branch') }}">
                            @error('branch')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label class="col-3 col-form-label">{{ __('Hoạt động') }}</label>
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
            <div class="col-md-8">
                <div class="k-portlet">
                    <div class="k-portlet__head">
                        <div class="k-portlet__head-label">
                            <h3 class="k-portlet__head-title">{{ __('Thông tin liên kết') }}</h3>
                        </div>
                    </div>
                    <div class="k-portlet__body">
                        <div class="form-group">
                            <label>{{ __('Sản phẩm được đề xuất') }}</label>
                            <select data-actions-box="true" name="suggested_relationships[inventories][]" title="-- {{ __('Chọn sản phẩm được đề xuất') }} --" data-size="5" data-live-search="true" class="form-control k_selectpicker Related_Product_Selector" multiple data-selected-text-format="count > 5">
                                @foreach($relatedInventories as $inventory)
                                <option
                                    {{ in_array($inventory->id, old('suggested_relationships.inventories', [])) ? 'selected' : '' }}
                                    data-tokens="{{ $inventory->id }} | {{ $inventory->title }}"
                                    data-subtext="{{ $inventory->id }}"
                                    data-product-id="{{ $inventory->id }}"
                                    data-product-name="{{ $inventory->title }}"
                                    value="{{ $inventory->id }}"
                                >{{ $inventory->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group Related_Product_Allowed_Holder mb-0">
                            <div class="Related_Product_Holder_Content">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Bài đăng được đề xuất') }}</label>
                            <select data-actions-box="true" name="suggested_relationships[posts][]" title="-- {{ __('Chọn bài đăng được đề xuất') }} --" data-size="5" data-live-search="true" class="form-control k_selectpicker Related_Post_Selector" multiple data-selected-text-format="count > 5">
                                @foreach($categoryRelatedPosts as $category)
                                <optgroup label="{{ $category->name }}">
                                    @foreach($category->posts as $post)
                                    <option
                                        {{ in_array($post->id, old("suggested_relationships.posts", [])) ? 'selected' : '' }}
                                        data-tokens="{{ $post->id }} | {{ $post->name }} | {{ $category->name }}"
                                        data-subtext="{{ $post->id }}"
                                        data-post-id="{{ $post->id }}"
                                        data-post-name="{{ $post->name }}"
                                        value="{{ $post->id }}">{{ $post->name }}</option>
                                    @endforeach
                                </optgroup>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group Related_Post_Allowed_Holder mb-0">
                            <div class="Related_Post_Holder_Content">
                            </div>
                        </div>
                    </div>

                    <div class="k-portlet__foot">
                        <div class="k-form__actions d-flex justify-content-end">
                            <button type="redirect" class="btn btn-secondary mr-2">{{ __('Huỷ') }}</button>
                            <button type="submit" class="btn btn-primary">{{ __('Lưu') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('js_script')
<script src="{{ asset('backoffice/assets/vendors/general/jquery.repeater/src/lib.js') }}" type="text/javascript"></script>
<script src="{{ asset('backoffice/assets/vendors/general/jquery.repeater/src/jquery.input.js') }}" type="text/javascript"></script>
<script src="{{ asset('backoffice/assets/vendors/general/jquery.repeater/src/repeater.js') }}" type="text/javascript"></script>
@include('backoffice.pages.products.js-pages.handle')
@include('backoffice.pages.products.js-pages.products-suggested')
@include('backoffice.pages.products.js-pages.posts-suggested')
<script>
    $('#form_store_product').on('submit', function(e) {
        e.preventDefault();

        const $form = $(this);

        const formData = FORM_MASTER.getFormData();
        const _token = $('input[name=_token]').val();

        formData.append('_token', _token);

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            preventRedirectOnComplete: 1,
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: () => {},
            success: (response) => {
                fstoast.success("{{ __('Created product success!') }}");
                window.location.href = "{{ route('bo.web.products.index') }}";
            },
            error: () => {
                fstoast.error("{{ __('Created product error!') }}");
                $form.find('[type="submit"]').prop('disabled', false);
            },
        });
    });
</script>
@endsection
