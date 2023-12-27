@extends('backoffice.layouts.master')

@php
	$title = __('Inventory');

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

@section('content_body')
<div class="k-content__body	k-grid__item k-grid__item--fluid" id="k_content_body">

    @include('backoffice.pages.inventories.partials.search-form')

    <div class="k-portlet k-portlet--mobile">
        <div class="k-portlet__head">
            <div class="k-portlet__head-label">
                <h3 class="k-portlet__head-title">
                    {{ __('Inventory') }}
                </h3>
            </div>
            <div class="k-portlet__head-toolbar">
                <div class="k-portlet__head-toolbar-wrapper">
                    @can('inventories.store')
                    <a href="javascript:void(0)" class="btn btn-brand btn-bold btn-upper btn-font-sm" data-toggle="modal" data-target="#modal_create_inventory">
                        <i class="la la-plus"></i>
                        {{ __('Create Inventory') }}
                    </a>
                    @endcan
                </div>
            </div>
        </div>
        <div class="k-portlet__body">
            <table id="table_inventories_index" data-searching="true" data-request-url="{{ route('bo.api.inventories.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                <thead>
                    <tr>
                        <th data-property="id">{{ __('ID') }}</th>
                        <th data-orderable="false" data-property="image" data-render-callback="renderCallbackImage">{{ __('Image') }}</th>
                        <th data-property="title">{{ __('Title') }}</th>
                        <th data-property="product" data-render-callback="renderCallbackProduct">{{ __('Product') }}</th>
                        <th data-property="sku">{{ __('Sku') }}</th>
                        <th data-property="slug">{{ __('Slug') }}</th>
                        <th data-orderable="false" data-badge data-name="status" data-property="status_name">{{ __('Status') }}</th>
                        <th data-orderable="false" data-badge data-name="display_on_frontend" data-property="display_on_frontend_name">{{ __('FE Display') }}</th>
                        <th data-orderable="false" data-badge data-name="allow_frontend_search" data-property="allow_frontend_search_name">{{ __('FE Search') }}</th>
                        <th data-orderable="false" data-badge data-name="condition" data-property="condition_name">{{ __('Condition') }}</th>
                        <th data-property="purchase_price">{{ __('Purchase Price') }}</th>
                        <th data-property="sale_price">{{ __('Sale Price') }}</th>
                        <th data-property="offer_price" data-render-callback="renderCallbackOfferPrice">{{ __('Offer Price') }}</th>
                        <th data-property="stock_quantity">{{ __('Stock Quantity') }}</th>
                        <th data-property="min_order_quantity">{{ __('Min Order Quantity') }}</th>
                        <th data-property="available_from">{{ __('Available From') }}</th>
                        <th data-orderable="false" data-property="created_by.name">{{ __('Created By') }}</th>
                        <th data-orderable="false" data-property="updated_by.name">{{ __('Updated By') }}</th>
                        <th data-property="created_at">{{ __('Created At') }}</th>
                        <th data-property="updated_at">{{ __('Updated At') }}</th>
                        <th class="datatable-action" data-property="actions">{{ __('Action') }}</th>
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
<div class="modal fade" id="modal_create_inventory" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border:none;">
            <form id="form_create_inventory" method="GET" action="{{ route('bo.web.inventories.create') }}">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ __('Create Inventory') }}
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ __('Product') }} *</label>
                        <select name="product_id" title="--{{ __('Select Product') }}--" class="form-control k_selectpicker" data-size="5" data-live-search="true">
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
                            <select name="attribute_values[{{ $attribute->id }}][]" title="--{{ __('Select Values') }}--" class="form-control k_selectpicker" data-size="5" data-live-search="true" multiple>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpush
@endcan

@section('js_script')
<script>
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

            $.each($('#form_create_inventory').find('.attribute-item'), function(index, element) {
                const supportedCategories = JSON.parse($(element).attr('data-supported-categories') || '[]');

                for (const item of supportedCategories) {
                    if (productCategories.includes(item)) {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }
                }
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

    function renderCallbackProduct(data, type, full) {
        if (! data) {
            return '';
        }

        const productRoute = "{{ route('bo.web.products.edit', ':id') }}".replace(':id', data?.id);

        const wrapper = $(`
            <div style="width: 200px;">
                <div class="offer_price d-flex align-items-center">
                    <img src="${data.primary_image}" width="30" height="30" />
                </div>
                <div class="d-flex align-items-center mt-2">
                    <b>
                        <a
                            href="${productRoute}"
                            title="${data.name}"
                            class="d-inline-block" style="white-space: nowrap; width: 155px; overflow: hidden; text-overflow: ellipsis;"
                        >${data.name ? '(' + data.id + ')' + data.name : 'N/A'}</a>
                    </b>
                </div>
            </div>
        `);

        return wrapper.prop('outerHTML');
    }

    function renderCallbackOfferPrice(data, type, full) {
        if (! data) {
            return '';
        }

        const wrapper = $(`
            <div style="width: 200px;">
                <div class="offer_price d-flex align-items-center">
                    <small style="display: block; width: 40px;">Price:</small> <b>${data ? data: 'N/A'}</b>
                </div>
                <div class="offer_start d-flex align-items-center">
                    <small style="display: block; width: 40px;">Start:</small> <b>${full.offer_start ? full.offer_start : 'N/A'}</b>
                </div>
                <div class="offer_end d-flex align-items-center">
                    <small style="display: block; width: 40px;">End:</small> <b>${full.offer_end ? full.offer_end : 'N/A'}</b>
                </div>
            </div>
        `);

        return wrapper.prop('outerHTML');
    }
</script>
@endsection
