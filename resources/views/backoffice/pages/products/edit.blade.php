@extends('backoffice.layouts.master')

@php
	$title = __('Chỉnh sửa sản phẩm') . ' #' . data_get($product, 'code');

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
	<form id="form_store_product" method="POST" action="{{ route('bo.web.products.update', $product->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @error('*')
        <div class="alert alert-danger fade show">
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

        <div class="product-preview mb-3">
            <div class="row">
                <div class="col-md-2">
                    <img src="{{ data_get($product, 'primary_image') }}" alt="{{ data_get($product, 'name') }}" style="width: 100%; height: auto;">
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <label for="">{{ __('Tên sản phẩm') }}</label>
                        <input type="text" class="form-control" disabled value="{{ data_get($product, 'name') }}">
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('SKU') }}</label>
                        <input type="text" class="form-control" disabled value="{{ data_get($product, 'code') }}">
                    </div>
                </div>
            </div>
        </div>

        <hr>

        @canany(['product-reviews.store'])
        <div class="k-portlet__head-toolbar mb-4">
            @can('product-reviews.store')
            <a href="{{ route('bo.web.product-reviews.create', ['target_product_id' => $product->id]) }}" target="_blank" class="btn btn-primary btn-sm">
                {{ __('Viết đánh giá') }}
            </a>
            @endcan
        </div>
        @endcanany

        <div class="k-portlet__head-toolbar">
            <ul class="nav nav-tabs nav-tabs-bold nav-tabs-line nav-tabs-line-brand d-flex">
                <li class="nav-item">
                    <a class="nav-link active show" data-toggle="tab" href="#Tag_General_Information">
                        {{ __('Thông tin chung') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#Tag_Detail_Information">
                        {{ __('Thông tin chi tiết') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#Tag_Connect_Information">
                        {{ __('Thông tin liên kết') }}
                    </a>
                </li>

                @can('inventories.index')
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#Tag_Inventories">
                        {{ __('Sản phẩm tồn kho') }}
                        <span>({{ optional($product->inventories)->count() }})</span>
                    </a>
                </li>
                @endcan

                @can('product-reviews.index')
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#Tag_Product_Review">
                        {{ __('Đánh giá sản phẩm') }}
                        <span>({{ optional($product->reviews)->count() }})</span>
                    </a>
                </li>
                @endcan
            </ul>
        </div>

        <div class="tab-content">
            <div class="tab-pane active show" id="Tag_General_Information">
                <div class="row">
                    <div class="col-md-12">
                        <div class="k-portlet">
                            <div class="k-portlet__body">
                                <div class="form-group">
                                    <label for="">{{ __('Tên') }} *</label>
                                    <input type="text" name="name" value="{{ old('name', $product->name) }}" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" data-reference-slug="slug" placeholder="{{ __('Nhập tên') }}" required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="">{{ __('Đường dẫn') }} *</label>
                                    <input type="text" name="slug" value="{{ old('slug', $product->slug) }}" class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" placeholder="{{ __('Nhập [SEO] tiêu đề') }}" required>
                                    @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="">{{ __('SKU Sản phẩm') }} *</label>
                                    <div class="input-group">
                                        <input type="hidden" name="code" value="{{ old('code', $product->code) }}">
                                        <input id="code" type="text" value="{{ old('code', $product->code) }}" class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" placeholder="{{ __('Nhập Code') }}" required disabled>
                                    </div>
                                    @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Loại sản phẩm') }} *</label>
                                    <select title="-- {{ __('Chọn loại sản phẩm') }} --" name="type" class="form-control k_selectpicker">
                                        @foreach($productTypeLabels as $key => $label)
                                        <option value="{{ $key }}" {{ old('type', $product->type) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Danh mục') }} *</label>
                                    <select name="categories[]" title="-- {{ __('Chọn danh mục') }} --" class="form-control k_selectpicker" data-size="5" multiple required data-live-search="true">
                                        @foreach($categoryGroups as $categoryGroup)
                                        <optgroup label="{{ $categoryGroup->name }}">
                                            @foreach($categoryGroup->categories as $category)
                                            <option value="{{ $category->id }}" {{ in_array($category->id, old('categories', $product->categories->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </optgroup>
                                        @endforeach
                                    </select>
                                    @error('categories')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Thương hiệu') }}</label>
                                    <input type="text" class="form-control {{ $errors->has('branch') ? 'is-invalid' : '' }}" name="branch" placeholder="{{ __('Nhập tên thương hiệu') }}" value="{{ old('branch', $product->branch) }}">
                                    @error('branch')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Hoạt động') }}</label>
                                    <div>
                                        <span class="k-switch k-switch--icon">
                                            <label>
                                                <input type="checkbox" {{ boolean(old('status', $product->status)) ? 'checked' : ''}} name="status"/>
                                                <span></span>
                                            </label>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="Tag_Detail_Information">
                <div class="row">
                    <div class="col-md-12">
                        <div class="k-portlet">
                            <div class="k-portlet__body">
                                <div class="form-group">
                                    <label>{{ __('Hình ảnh') }} *</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="upload_image_custom position-relative">
                                                <input type="text" data-image-ref-path="primary" data-image-ref-index="0" class="form-control image_primary_image_url" name="primary_image[path]" value="{{ old('primary_image.path', $product->primary_image) }}" placeholder="{{ __('Tải ảnh lên hoặc nhập URL ảnh') }}" style="padding-right: 104px;">
                                                <div data-image-ref-wrapper="primary" data-image-ref-index="0" class="d-none w-100 position-absolute d-none" style="top: 50%; left: 4px; transform: translateY(-50%); height: 90%; background-color: #fff;">
                                                    <div class="d-flex align-items-center h-100">
                                                        <img data-image-ref-img="primary" data-image-ref-index="0" src="" alt="Image preview" class="mr-2" style="height: 100%; width: 100px;">
                                                        <span data-image-ref-delete="primary" data-image-ref-index="0" style="font-size: 16px; cursor: pointer;">&times;</span>
                                                    </div>
                                                </div>
                                                <label for="image_primary_image" class="btn position-absolute btn-secondary upload_image_custom_append_icon btn-sm d-flex">
                                                    <input type="file" id="image_primary_image" data-image-ref-file="primary" data-image-ref-index="0" name="primary_image[file]" class="d-none image_primary_image_file">
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
                                            @foreach (old('media.image', data_get($product->media, 'image', [])) as $index => $mediaImage)
                                            <div data-repeater-item class="k-repeater__item" data-repeater-index="{{ $index }}">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="upload_image_custom position-relative">
                                                            <input type="text" data-image-ref-path="media" data-image-ref-index="{{ $index }}" class="form-control media_image_path" name="path" placeholder="{{ __('Tải ảnh lên hoặc nhập URL ảnh') }}" style="padding-right: 104px;" value="{{ old('primary_image.path', data_get($mediaImage, 'path')) }}">
                                                            <div data-image-ref-wrapper="media" data-image-ref-index="{{ $index }}" class="d-none w-100 position-absolute d-none" style="top: 50%; left: 4px; transform: translateY(-50%); height: 90%; background-color: #fff;">
                                                                <div class="d-flex align-items-center h-100">
                                                                    <img data-image-ref-img="media" data-image-ref-index="{{ $index }}" src="" alt="Image preview" class="mr-2" style="height: 100%; width: 100px;">
                                                                    <span data-image-ref-delete="media" data-image-ref-index="{{ $index }}" style="font-size: 16px; cursor: pointer;">&times;</span>
                                                                </div>
                                                            </div>
                                                            <label for="media_image_file_{{ $index }}" class="media_image_file_wapper btn position-absolute btn-secondary upload_image_custom_append_icon btn-sm d-flex">
                                                                <input type="file" name="file" data-image-ref-file="media" data-image-ref-index="{{ $index }}" id="media_image_file_{{ $index }}" class="d-none media_image_file">
                                                                <i class="flaticon2-image-file"></i>
                                                                <span>{{ __('Tải lên') }}</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="d-flex align-items-start">
                                                            <div class="image_media_image_review mr-1">
                                                                <div data-image-ref-review-wrapper="media" data-image-ref-index="{{ $index }}" class="d-none" style="width: 100px; height: 100px; border: 1px solid #ccc;">
                                                                    <img data-image-ref-review-img="media" data-image-ref-index="{{ $index }}" style="width: 100%; height: 100%;" src="" alt="">
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
                                            @endforeach
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
                                        <input type="text" name="media[video][0][path]" value="{{ old("media.video.1.path", data_get($product, ['media', 'video', '0', 'path'])) }}" class="form-control {{ $errors->has('media.video.0.path') ? 'is-invalid' : '' }}" placeholder="{{ __('Nhập đường dẫn video') }}">
                                        <input type="hidden" name="media[video][0][order]" value="1">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <x-content-editor id="description" label="{{ __('Mô tả') }}" name="description" value="{{ old('description', $product->description) }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="Tag_Connect_Information">
                <div class="row">
                    <div class="col-md-12">
                        <div class="k-portlet">
                            <div class="k-portlet__body">
                                <div class="form-group">
                                    <label>{{ __('Sản phẩm liên quan') }}</label>
                                    <select data-actions-box="true" name="suggested_relationships[inventories][]" title="-- {{ __('Sản phẩm liên quan') }} --" data-size="5" data-live-search="true" class="form-control k_selectpicker Related_Product_Selector" multiple data-selected-text-format="count > 5">
                                        @foreach($relatedInventories as $inventory)
                                        <option
                                            {{ in_array($inventory->id, old('suggested_relationships.inventories', data_get($product, 'suggested_relationships.inventories', []))) ? 'selected' : '' }}
                                            data-tokens="{{ $inventory->id }} | {{ $inventory->title }} | {{ $inventory->sku }}"
                                            data-product-id="{{ $inventory->id }}"
                                            data-product-name="{{ $inventory->title }}"
                                            value="{{ $inventory->id }}"
                                        >{{ $inventory->title }}</option>
                                        @endforeach
                                    </select>
                                    <div class="form-group Related_Product_Allowed_Holder mb-0 mt-2">
                                        <div class="Related_Product_Holder_Content"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Bài viết liên quan') }}</label>
                                    <select data-actions-box="true" name="suggested_relationships[posts][]" title="-- {{ __('Bài viết liên quan') }} --" data-size="5" data-live-search="true" class="form-control k_selectpicker Related_Post_Selector" multiple data-selected-text-format="count > 5">
                                        @foreach($categoryRelatedPosts as $category)
                                        <optgroup label="{{ $category->name }}">
                                            @foreach($category->posts as $post)
                                            <option
                                                {{ in_array($post->id, old("suggested_relationships.posts", data_get($product, 'suggested_relationships.posts', []))) ? 'selected' : '' }}
                                                data-tokens="{{ $post->id }} | {{ $post->name }} | {{ $post->code }} | {{ $category->name }}"
                                                data-post-id="{{ $post->id }}"
                                                data-post-name="{{ $post->name }}"
                                                value="{{ $post->id }}">{{ $post->name }}</option>
                                            @endforeach
                                        </optgroup>
                                        @endforeach
                                    </select>
                                    <div class="form-group Related_Post_Allowed_Holder mb-0 mt-2">
                                        <div class="Related_Post_Holder_Content"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @can('inventories.index')
            <div class="tab-pane" id="Tag_Inventories">
                <div class="row">
                    <div class="col-md-12">
                        <div class="k-portlet">
                            <div class="k-portlet__body">
                                <table id="table_inventories_index" data-searching="true" data-request-url="{{ route('bo.api.inventories.index', ['product_id' => $product->id]) }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                                    <thead>
                                        <tr>
                                            <th data-property="id">{{ __('ID') }}</th>
                                            <th data-orderable="false" data-property="image" data-render-callback="renderCallbackImage">{{ __('Hình ảnh') }}</th>
                                            <th data-orderable="false" data-badge data-name="status" data-property="status_name">{{ __('Trạng thái') }}</th>
                                            <th data-orderable="false" data-badge data-name="display_on_frontend" data-property="display_on_frontend_name">{{ __('Hiển Thị FE') }}</th>
                                            <th data-orderable="false" data-badge data-name="allow_frontend_search" data-property="allow_frontend_search_name">{{ __('Tìm kiếm FE') }}</th>
                                            <th data-property="purchase_price">{{ __('Giá mua') }}</th>
                                            <th data-property="sale_price">{{ __('Giá bán') }}</th>
                                            <th data-property="offer_price" data-render-callback="renderCallbackOfferPrice">{{ __('Giá khuyến mãi') }}</th>
                                            <th data-property="sold_count">{{ __('Đã bán') }}</th>
                                            <th class="datatable-action" data-property="actions">{{ __('Hành động') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endcan

            @can('product-reviews.index')
            <div class="tab-pane" id="Tag_Product_Review">
                <div class="row">
                    <div class="col-md-12">
                        <div class="k-portlet">
                            <div class="k-portlet__body">
                                <table id="table_product_reviews_index" data-searching="true" data-request-url="{{ route('bo.api.product-reviews.index', ['product_id' => $product->id]) }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                                    <thead>
                                        <tr>
                                            <th data-property="id">{{ __('ID') }}</th>
                                            <th data-property="user_name" data-render-callback="renderCallbackUserName">{{ __('Tên khách hàng') }}</th>
                                            <th data-property="user_phone">{{ __('Số điện thoại') }}</th>
                                            <th data-property="user_email">{{ __('E-mail') }}</th>
                                            <th data-orderable="false" data-badge data-name="rating_type" data-property="rating_type_name">{{ __('Loại xếp hạng') }}</th>
                                            <th data-orderable="false" data-badge data-name="status" data-property="status_name">{{ __('Trạng thái') }}</th>
                                            <th data-property="post_at">{{ __('Review lúc') }}</th>
                                            <th data-orderable="false" data-property="created_by.name">{{ __('Người tạo') }}</th>
                                            <th data-orderable="false" data-property="updated_by.name">{{ __('Người cập nhật') }}</th>
                                            <th data-property="created_at">{{ __('Ngày tạo') }}</th>
                                            <th data-property="updated_at">{{ __('Ngày cập nhật') }}</th>
                                            <th class="datatable-action" data-property="actions">{{ __('Hành động') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endcan
        </div>

        <div class="col-md-12">
            <div class="k-portlet__foot">
                <div class="k-form__actions d-flex justify-content-start">
                    <button type="redirect" class="btn btn-secondary mr-2">{{ __('Huỷ') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Lưu') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@component('backoffice.partials.datatable') @endcomponent

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
        formData.append('_method', 'PUT');

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            preventRedirectOnComplete: 1,
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: () => {},
            success: (response) => {
                fstoast.success("{{ __('Updated product success!') }}");
                window.location.href = "{{ route('bo.web.products.index') }}";
            },
            error: () => {
                fstoast.error("{{ __('Updated product error!') }}");
                $form.find('[type="submit"]').prop('disabled', false);
            },
        });
    });

    $('[name="status"]').on('change', function() {
        const isChecked = $(this).is(':checked');

        $(this).prop('checked', isChecked);
        $(this).val(isChecked ? '1' : '0')
    });

    $('.datatable').find('th.datatable-action').attr('data-action-icon-pack', JSON.stringify({
        fe_link: '<i class="flaticon2-link-programing-symbol-of-interface"></i>',
    }))

    $(document).on('click', '[data-action="fe_link"]', function(e) {
        e.preventDefault();

        const dataLink = $(this).attr('href');

        copyToClipboard(dataLink);

        fstoast.success("{{ __('Đã sao chép !') }}");
    });

    function renderCallbackImage(data, type, full) {
        const container = $(`
            <div style="width: 200px;">
                <img src="${data}" width="50" height="50" />
                <div class="mt-2">- ${full.title}</div>
                <div class="mt-2">- SKU: ${full.sku}</div>
                <div class="mt-2">- Còn: ${full.stock_quantity}(sp) trong kho</div>
            </div>
        `);

        return container.prop('outerHTML');
    }

    function renderCallbackOfferPrice(data, type, full) {
        if (! data) {
            return '';
        }

        const wrapper = $(`
            <div style="width: 200px;">
                <div class="offer_price d-flex align-items-center">
                    <small style="display: block; width: 60px;">Giá bán:</small> <b>${data ? data: 'N/A'}</b>
                </div>
                <div class="offer_end d-flex align-items-center">
                    <small style="display: block; width: 60px;">Tiếp kiệm:</small> <b>${full.price_for_saving ? full.price_for_saving : 'N/A'}</b>
                </div>
                <div class="offer_end d-flex align-items-center">
                    <small style="display: block; width: 60px;">Giảm giá:</small> <b>${full.discount_percent ? full.discount_percent + '%' : 'N/A'}</b>
                </div>
                <div class="offer_start d-flex align-items-center">
                    <small style="display: block; width: 60px;">Bắt đầu:</small> <b>${full.offer_start ? full.offer_start : 'N/A'}</b>
                </div>
                <div class="offer_end d-flex align-items-center">
                    <small style="display: block; width: 60px;">Kết thúc:</small> <b>${full.offer_end ? full.offer_end : 'N/A'}</b>
                </div>
            </div>
        `);

        return wrapper.prop('outerHTML');
    }

    onDeleteInventory();

    function onDeleteInventory() {
        $(document).on('click', '#table_inventories_index [data-action=delete]', function(e) {
            e.preventDefault();

            let confirmation = confirm("{{ __('Bạn có chắc chắn muốn xóa sản phẩm này trong kho?') }}");

            if(!confirmation) {
                return;
            }

            $.ajax({
                url: $(this).attr('href'),
                method: 'delete',
                preventRedirectOnComplete: 1,
                success: function(res) {
                    $('#table_inventories_index').DataTable().ajax.reload()
                }
            });
        });
    }

    onDeleteProductReview();

    function onDeleteProductReview() {
        $(document).on('click', '#table_product_reviews_index [data-action=delete]', function(e) {
            e.preventDefault();

            let confirmation = confirm("{{ __('Bạn có chắc chắn muốn xóa Đánh giá sản phẩm này ?') }}");

            if(!confirmation) {
                return;
            }

            $.ajax({
                url: $(this).attr('href'),
                method: 'delete',
                preventRedirectOnComplete: 1,
                success: function(res) {
                    $('#table_product_reviews_index').DataTable().ajax.reload()
                }
            });
        });
    }

    function renderCallbackProductName(data, type, full) {
        const href = $('<a>', {
            href: "{{ route('bo.web.products.edit', ':id') }}".replace(':id', full.id),
            target: '_blank',
            text: data
        });

        return href.prop('outerHTML');
    }

    function renderCallbackUserName(data, type, full) {
        const div = $('<div>').append(`
            <span>${data}</span> ${full.is_real_user ? '<b>[REAL]</b>' : ''}
        `);

        return div.prop('outerHTML');
    }
</script>
@endsection
