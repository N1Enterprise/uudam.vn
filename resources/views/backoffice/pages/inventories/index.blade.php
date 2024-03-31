@extends('backoffice.layouts.master')

@php
	$title = __('Sản phẩm tồn kho');

	$breadcrumbs = [
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
    .group-value {
        font-weight: bold!important;
    }
</style>
@endsection

@section('content_body')
<div class="k-content__body	k-grid__item k-grid__item--fluid" id="k_content_body">

    @include('backoffice.pages.inventories.partials.search-form')

    <div class="k-portlet k-portlet--mobile">
        <div class="k-portlet__head">
            <div class="k-portlet__head-label">
                <h3 class="k-portlet__head-title">
                    {{ __('Danh sách sản phẩm tồn kho') }}
                </h3>
            </div>
            <div class="k-portlet__head-toolbar">
                <div class="k-portlet__head-toolbar-wrapper">
                    @can('inventories.store')
                    <a href="javascript:void(0)" class="btn btn-brand btn-bold btn-upper btn-font-sm" data-toggle="modal" data-target="#modal_create_inventory">
                        <i class="la la-plus"></i>
                        {{ __('Tạo sản phẩm vào kho') }}
                    </a>
                    @endcan
                </div>
            </div>
        </div>
        <div class="k-portlet__body">
            <table id="table_inventories_index" data-group-column="3" data-searching="true" data-request-url="{{ route('bo.api.inventories.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                <thead>
                    <tr>
                        <th data-property="id">{{ __('ID') }}</th>
                        <th data-orderable="false" data-property="image" data-render-callback="renderCallbackImage">{{ __('Hình ảnh') }}</th>
                        <th data-property="title" data-width="300">{{ __('Tiêu đề') }}</th>
                        <th data-orderable="false" data-property="product.name">{{ __('Sản phẩm') }}</th>
                        <th data-property="sku">{{ __('Sku') }}</th>
                        <th data-orderable="false" data-badge data-name="status" data-property="status_name">{{ __('Trạng thái') }}</th>
                        <th data-orderable="false" data-badge data-name="display_on_frontend" data-property="display_on_frontend_name">{{ __('Hiển Thị FE') }}</th>
                        <th data-orderable="false" data-badge data-name="allow_frontend_search" data-property="allow_frontend_search_name">{{ __('Tìm kiếm FE') }}</th>
                        <th data-property="stock_quantity">{{ __('Số lượng') }}</th>
                        <th data-property="purchase_price">{{ __('Giá mua') }}</th>
                        <th data-property="sale_price">{{ __('Giá bán') }}</th>
                        <th data-property="offer_price" data-render-callback="renderCallbackOfferPrice">{{ __('Giá khuyến mãi') }}</th>
                        <th data-property="init_sold_count">{{ __('Fake Đã bán') }}</th>
                        <th data-property="sold_count">{{ __('Đã bán') }}</th>
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
@endsection

@component('backoffice.partials.datatable') @endcomponent

@can('inventories.store')
@push('modals')
<div class="modal fade" id="modal_create_inventory" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border:none;">
            <form id="form_create_inventory" method="GET" action="{{ route('bo.web.inventories.create') }}">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ __('Tạo sản phẩm vào kho') }}
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ __('Sản phẩm') }} *</label>
                        <select name="product_id" title="-- {{ __('Chọn sản phẩm') }} --" class="form-control k_selectpicker" data-size="5" data-live-search="true">
                            @foreach($categories as $category)
                            <optgroup label="{{ $category->name }}">
                                @foreach($category->products as $product)
                                <option value="{{ $product->id }}" data-product-type="{{ $product->type }}" data-categories='@json($product->categories->pluck('id')->toArray())'>{{ $product->name }} ({{ $product->type_name }})</option>
                                @endforeach
                            </optgroup>
                            @endforeach
                        </select>
                        @error('product_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="has_attributes">
                        @foreach ($attributes as $attribute)
                        <div class="form-group attribute-item d-none" data-supported-categories='@json($attribute->supported_categories ?? [])'>
                            <label>{{ $attribute->name }}</label>
                            <select name="attribute_values[{{ $attribute->id }}][]" title="-- {{ __('Chọn biến thể') }} --" class="form-control k_selectpicker" data-size="5" data-live-search="true" multiple>
                                @foreach ($attribute->attributeValues as $value)
                                <option value="{{ $value->id }}">{{ $value->value }}</option>
                                @endforeach
                            </select>
                            @error('product_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer" style="border-top: none;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Đóng') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Lưu') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpush
@endcan

@section('js_script')
<script>
    $('.datatable').find('th.datatable-action').attr('data-action-icon-pack', JSON.stringify({
        fe_link: '<i class="flaticon2-link-programing-symbol-of-interface"></i>',
    }))

    $(document).on('click', '[data-action="fe_link"]', function(e) {
        e.preventDefault();

        const dataLink = $(this).attr('href');

        copyToClipboard(dataLink);

        fstoast.success("{{ __('Đã sao chép !') }}");
    });

    // @class App\Enum\ProductTypeEnum
    const PRODUCT_TYPE_ENUM = {
        SIMPLE: 1,
        VARIABLE: 2
    };

    onChangeInventoryProduct();

    function onChangeInventoryProduct() {
        $('#form_create_inventory').find('[name="product_id"]').on('change', function() {
            const productId = $(this).val();
            const productType = $('#form_create_inventory').find(`option[value="${productId}"]`).attr('data-product-type');
            const productCategories = JSON.parse($('#form_create_inventory').find(`option[value="${productId}"]`).attr('data-categories') || '[]');

            $('#form_create_inventory').find('.attribute-item').addClass('d-none');

            if (productType == PRODUCT_TYPE_ENUM.SIMPLE) {
                return;
            }

            $.each($('#form_create_inventory').find('.attribute-item'), function(index, element) {
                const supportedCategories = JSON.parse($(element).attr('data-supported-categories') || '[]');

                const has = supportedCategories.some(item => productCategories.includes(item));

                $(element).toggleClass('d-none', !has);
            });
        });
    }

    function renderCallbackImage(data) {
        const image = $('<img>', {
            src: data,
            width: 80,
            height: 80,
        });

        return image.prop('outerHTML');
    }

    function renderCallbackOfferPrice(data, type, full) {
        if (! data) {
            return '';
        }

        const wrapper = $(`
            <div style="width: 200px;">
                <div class="offer_price d-flex align-items-center">
                    <small style="display: block; width: 60px;">Price:</small> <b>${data ? data: 'N/A'}</b>
                </div>
                <div class="offer_end d-flex align-items-center">
                    <small style="display: block; width: 60px;">Saving:</small> <b>${full.price_for_saving ? full.price_for_saving : 'N/A'}</b>
                </div>
                <div class="offer_end d-flex align-items-center">
                    <small style="display: block; width: 60px;">Discount:</small> <b>${full.discount_percent ? full.discount_percent + '%' : 'N/A'}</b>
                </div>
                <div class="offer_start d-flex align-items-center">
                    <small style="display: block; width: 60px;">Start:</small> <b>${full.offer_start ? full.offer_start : 'N/A'}</b>
                </div>
                <div class="offer_end d-flex align-items-center">
                    <small style="display: block; width: 60px;">End:</small> <b>${full.offer_end ? full.offer_end : 'N/A'}</b>
                </div>
            </div>
        `);

        return wrapper.prop('outerHTML');
    }

    onDelete();

    function onDelete() {
        $(document).on('click', '[data-action=delete]', function(e) {
            e.preventDefault();

            let confirmation = confirm("{{ __('Are you sure you want to delete this Inventory?') }}");

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
</script>
@endsection
