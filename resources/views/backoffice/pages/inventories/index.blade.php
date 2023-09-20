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
    @include('backoffice.partials.message')
    <div class="k-portlet k-portlet--mobile">
        <div class="k-portlet__head">
            <div class="k-portlet__head-label">
                <h3 class="k-portlet__head-title">
                    {{ __('Inventory') }}
                </h3>
            </div>
            @canAny(['inventories.store'])
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
            @endcan
        </div>
        <div class="k-portlet__body">
            <table id="table_inventories_index" data-searching="true" data-request-url="{{ route('bo.api.inventories.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                <thead>
                    <tr>
                        <th data-property="id">{{ __('ID') }}</th>
                        <th data-property="name">{{ __('Title') }}</th>
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

@push('modals')
<div class="modal fade" id="modal_create_inventory" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border:none;">
            <form id="form_create_inventory" method="GET" action="{{ route('bo.web.inventories.create') }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="selectGamesModal">
                        {{ __('Create Inventory') }}
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ __('Product') }} *</label>
                        <select name="product_id" title="--{{ __('Select Product') }}--" class="form-control k_selectpicker" data-size="5">
                            @foreach($categories as $category)
                            <optgroup label="{{ $category->name }}">
                                @foreach($category->products as $product)
                                <option value="{{ $product->id }}" data-product-type="{{ $product->type }}">{{ $product->name }} ({{ $product->type_name }})</option>
                                @endforeach
                            </optgroup>
                            @endforeach
                        </select>
                        @error('product_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="has_attributes d-none">
                        @foreach ($attributes as $attribute)
                        <div class="form-group">
                            <label>{{ $attribute->name }}</label>
                            <select name="attribute_values[{{ $attribute->id }}][]" title="--{{ __('Select Values') }}--" class="form-control k_selectpicker" data-size="5" multiple>
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

            $('#form_create_inventory').find('.has_attributes').toggleClass('d-none', productType != PRODUCT_TYPE_ENUM.VARIABLE);
        });
    }
</script>
@endsection
