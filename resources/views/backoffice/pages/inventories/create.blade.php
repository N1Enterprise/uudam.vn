@extends('backoffice.layouts.master')

@php
	$title = __('Sản phẩm tồn kho');

    $action = empty($inventory->id) ? __('Tạo') : __('Chỉnh sửa');

	$breadcrumbs = [
		[
			'label' => $title,
		],
		[
			'label' => __("{$action} sản phẩm kho"),
		]
	];
@endphp

@section('header')
{{ __($title) }}
@endsection

@section('style')
@include('backoffice.pages.inventories.style-pages.common')
@endsection

@component('backoffice.partials.breadcrumb', ['items' => $breadcrumbs]) @endcomponent

@section('content_body')
<div class="k-content__body	k-grid__item k-grid__item--fluid" id="k_content_body">
    <form id="form_inventory" method="POST" action="{{ empty($inventory->id) ? route('bo.web.inventories.store') : route('bo.web.inventories.update', $inventory->id) }}" enctype="multipart/form-data">
        @csrf
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
        @if(! empty($inventory->id)) @method('PUT') @endif
        <input type="hidden" id="INVENTORY_DATA" value='@json($inventory)' data-is-edit="{{ boolean(! empty($inventory->id)) }}">
        <input type="hidden" name="slug" value="{{ $inventory->slug }}">

        <div class="row">
            <div class="col-md-12">
                <div class="k-portlet">
                    <div class="k-portlet__head">
                        <div class="k-portlet__head-label">
                            <h3 class="k-portlet__head-title">{{ __('SẢN PHẨM') }}</h3>
                        </div>
                    </div>
                    <div class="k-portlet__body">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="thumnail" style="width: 100%; height: 170px; padding: 3px; border: 1px solid #bbbbbb;">
                                    <img src="{{ $product->primary_image }}" class="w-100 h-100" style="object-fit: cover;" alt="Primary image">
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="product_slug" value="{{ $product->slug }}">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">{{ __('Tên') }} *</label>
                                            <input type="text" class="form-control" value="{{ $product->name }}" required disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">{{ __('Mã sản phẩm') }} *</label>
                                            <input type="text" class="form-control" value="{{ $product->code }}" required disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">{{ __('Đường dẫn') }} *</label>
                                            <input type="text" class="form-control" value="{{ $product->slug }}" required disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">{{ __('Thương hiệu') }} *</label>
                                            <input type="text" class="form-control" value="{{ $product->branch }}" required disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">{{ __('Danh mục') }} *</label>
                                            <input type="text" class="form-control" value="{{ implode(', ', $product->categories->pluck('name')->toArray()) }}" required disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">{{ __('Trạng thái') }} *</label>
                                            <input type="text" class="form-control" value="{{ $product->status_name }}" required disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="k-portlet">
                    <div class="k-portlet__head">
                        <div class="k-portlet__head-label">
                            <h3 class="k-portlet__head-title">{{ __('SẢN PHẨM KHO') }}</h3>
                        </div>
                    </div>

                    <div class="k-portlet__body">
                        @if ($inventory->id)
                        <div class="form-group">
                            <label for="">{{ __('Xem chi tiết') }} *</label>

                            <div>
                                <a href="{{ route('fe.web.products.index', ['slug' => data_get($inventory, 'slug'), 'sku' => data_get($inventory, 'sku')]) }}" target="_blank">
                                    {{ route('fe.web.products.index', ['slug' => data_get($inventory, 'slug'), 'sku' => data_get($inventory, 'sku')]) }}
                                </a>

                                <button type="button" data-copy-clipboard data-copy-clipboard-content="{{ route('fe.web.products.index', ['slug' => data_get($inventory, 'slug'), 'sku' => data_get($inventory, 'sku')]) }}" class="btn btn-sm btn-outline-primary ml-2">{{ __('COPY') }}</button>
                            </div>
                        </div>
                        @endif

                        <div class="form-group">
                            <label for="">{{ __('Tiêu đề') }} *</label>
                            <input
                                type="text"
                                name="title"
                                class="form-control"
                                value="{{ old('title', data_get($inventory, 'title', $product->name)) }}"
                                data-reference-slug="slug"
                                required
                            >
                        </div>

                        @if ($inventory->id)
                        <div class="form-group">
                            <label for="">{{ __('Đường dẫn') }} *</label>
                            <input
                                type="text"
                                name="slug"
                                class="form-control"
                                value="{{ old('slug', data_get($inventory, 'slug')) }}"
                                required
                            >
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('Có sẵn từ') }}
                                        <i
                                            data-toggle="tooltip"
                                            data-title="Ngày mà hàng sẽ có sẵn. Mặc định = ngay lập tức"
                                            class="flaticon-questions-circular-button"
                                        ></i>
                                    </label>
                                    <input
                                        type="datetimepicker"
                                        class="form-control @error('available_from') is-invalid @enderror"
                                        name="available_from"
                                        value="{{ old('available_from', data_get($inventory, 'available_from', date('Y-m-d h:i:s', strtotime(now())))) }}"
                                    >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('Số lượng đặt hàng tối thiểu') }}
                                        <i
                                            data-toggle="tooltip"
                                            class="flaticon-questions-circular-button"
                                            data-title="Số lượng cho phép nhận đặt hàng. Phải là một giá trị số nguyên. Mặc định = 1"
                                        ></i>
                                    </label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        name="min_order_quantity"
                                        value="{{ old('min_order_quantity', data_get($inventory, 'min_order_quantity')) }}"
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('Khối lượng(g)') }}</label>
                                    <div class="input-group">
                                        <x-number-input
                                            name="weight"
                                            key="weight"
                                            class='form-control {{ $errors->has("weight") ? "is-invalid" : "" }}'
                                            placeholder="{{ __('10,01') }}"
                                            value='{{ old("weight", $inventory->weight) }}'
                                        />
                                        <div class="input-group-append"><span class="input-group-text">{{ __('gam(g)') }}</span></div>
                                    </div>
                                    @error('weight')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('Fake số lượng bán') }}
                                        <i
                                            data-toggle="tooltip"
                                            class="flaticon-questions-circular-button"
                                            data-title="{{ __('Số lượng đã bán này chỉ dành cho khách hàng sử dụng.') }}"
                                        ></i>
                                    </label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        name="init_sold_count"
                                        min="0"
                                        value="{{ old('init_sold_count', data_get($inventory, 'init_sold_count')) }}"
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('Ngày bắt đầu ưu đãi') }}
                                        <i
                                            data-toggle="tooltip"
                                            class="flaticon-questions-circular-button"
                                            data-title="Một khuyến mãi phải có ngày bắt đầu. Bắt buộc nếu trường giá ưu đãi được cung cấp"
                                        ></i>
                                    </label>
                                    <input
                                        type="datetimepicker"
                                        class="form-control @error('offer_start') is-invalid @enderror"
                                        name="offer_start"
                                        value="{{ old('offer_start', $inventory->offer_start) }}"
                                    >
                                    @error('offer_start')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('Ngày kết thúc ưu đãi') }}</label>
                                    <input
                                        type="datetimepicker"
                                        class="form-control @error('offer_end') is-invalid @enderror"
                                        name="offer_end"
                                        value="{{ old('offer_end', $inventory->offer_end) }}"
                                    >
                                    @error('offer_end')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <x-content-editor id="condition_note" label="{{ __('Điều kiện mua kèm') }}" name="condition_note" value="{{ old('condition_note', data_get($inventory, 'condition_note')) }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($hasVariant && empty($inventory->id))
        <div class="row">
            <div class="col-md-12">
                <div class="k-portlet">
                    <div class="k-portlet__head">
                        <div class="k-portlet__head-label">
                            <h3 class="k-portlet__head-title">{{ __('CÓ BIẾN THỂ') }}</h3>
                        </div>
                    </div>
                    <div class="k-portlet__body">
                        @include('backoffice.pages.inventories.partials.variant')
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-md-12">
                <div class="k-portlet">
                    <div class="k-portlet__head">
                        <div class="k-portlet__head-label">
                            @php
                                $invAttrs = $inventory->attributes;
                                $invAttrVals = $inventory->attributeValues->pluck('value', 'attribute_id')->toArray();

                                $invAttrTitles = optional($invAttrs)->map(function($attr) use ($invAttrVals) {
                                    return data_get($attr, 'name') .' : '. data_get($invAttrVals, data_get($attr, 'id'), '');
                                });

                            @endphp
                            <h3 class="k-portlet__head-title">{{ optional($invAttrTitles)->isEmpty() ? __('KHÔNG CÓ BIẾN THỂ') : $invAttrTitles->implode('; ') }}</h3>
                        </div>
                    </div>
                    <div class="k-portlet__body">
                        @include('backoffice.pages.inventories.partials.simple')
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="k-portlet">
                    <div class="k-portlet__head">
                        <div class="k-portlet__head-label">
                            <h3 class="k-portlet__head-title">{{ __('ĐẶC ĐIỂM NỔI BẬT') }}</h3>
                        </div>
                    </div>
                    <div class="k-portlet__body">
                        @include('backoffice.pages.inventories.partials.key-features')
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="k-portlet">
                    <div class="k-portlet__head">
                        <div class="k-portlet__head-label">
                            <h3 class="k-portlet__head-title">{{ __('THÔNG TIN') }}</h3>
                        </div>
                    </div>
                    <div class="k-portlet__body">
                        <div class="form-group">
                            <label for="">{{ __('Meta') }}</label>
                            <div id="json_editor_meta" style="height: 200px"></div>
                            <input type="hidden" name="meta" value="{{ old('meta', display_json_value($inventory->meta)) }}">
                        </div>

                        <div class="form-group">
                            <label>{{ __('[SEO] Tiêu đề') }}</label>
                            <input
                                type="text"
                                class="form-control {{ $errors->has('meta_title') ? 'is-invalid' : '' }}"
                                name="meta_title"
                                placeholder="{{ __('Nhập [SEO] tiêu đề') }}"
                                value="{{ old('meta_title', $inventory->meta_title) }}"
                            >
                            @error('meta_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('[SEO] Mô tả') }}</label>
                            <input
                                type="text"
                                class="form-control {{ $errors->has('meta_description') ? 'is-invalid' : '' }}"
                                name="meta_description"
                                placeholder="{{ __('Nhập [SEO] tiêu đề') }}"
                                value="{{ old('meta_description', $inventory->meta_description) }}"
                            >
                            @error('meta_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label class="col-2 col-form-label">{{ __('Hiển thị FE') }}</label>
                            <div class="col-3">
                                <span class="k-switch">
                                    <label>
                                        <input type="checkbox" {{ boolean(old('display_on_frontend', $inventory->display_on_frontend)) ? 'checked' : '' }} value="1" name="display_on_frontend" />
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
                                        <input type="checkbox" {{ boolean(old('allow_frontend_search', $inventory->allow_frontend_search)) ? 'checked' : '' }} value="1" name="allow_frontend_search" />
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
                                        <input type="checkbox" {{ boolean(empty($inventory->id) ? 1 : old('status', $inventory->status) ) ? 'checked' : '' }} value="1" name="status" />
                                        <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="k-portlet">
                    @if(!empty($inventory->id))
                    <div class="k-portlet__head">
                        <div class="k-portlet__head-label">
                            <h3 class="k-portlet__head-title">{{ __('COMBO THEO KÈO SẢN PHẨM KHO') }}</h3>
                        </div>
                    </div>

                    <div class="k-portlet__body">
                        @include('backoffice.pages.inventories.partials.product-combo')
                    </div>
                    @endif

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.4/ace.js" type="text/javascript"></script>
@include('backoffice.pages.inventories.js-pages.handle')
@include('backoffice.pages.inventories.js-pages.product-combos')
<script>
    $(document).ready(function() {
        FORM_MEDIA_IMAGE_PATH.triggerChange();
    });

    $(document).ready(function () {
        let editorMeta = ace.edit($('#json_editor_meta')[0], {
            mode: "ace/mode/json",
            theme: 'ace/theme/tomorrow',
            value: $(`input[name="meta"]`).val()
        });

        $('form#form_inventory').on('submit', function(e) {
            e.preventDefault();
            let editorMetaElement = $(`input[name="meta"]`).val(editorMeta.getValue());
            $(this).append(editorMetaElement);
            $(this)[0].submit();
        });
    });
</script>
@endsection
