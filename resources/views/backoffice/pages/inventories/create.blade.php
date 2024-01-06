@extends('backoffice.layouts.master')

@php
	$title = __('Inventories');

    $action = empty($inventory->id) ? 'Add' : 'Edit';

	$breadcrumbs = [
		[
			'label' => $title,
		],
		[
			'label' => __("{$action} Inventory"),
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
        <div class="alert alert-danger fade show" role="alert">
            <div class="alert-text">
                {{ __('Submit failed. Please check the error below.') }}
            </div>
            <div class="alert-close">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="la la-close"></i></span>
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
                            <h3 class="k-portlet__head-title">{{ __('PRODUCT') }}</h3>
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
                                            <label for="">{{ __('Name') }} *</label>
                                            <input type="text" class="form-control" value="{{ $product->name }}" required disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">{{ __('Code') }} *</label>
                                            <input type="text" class="form-control" value="{{ $product->code }}" required disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">{{ __('Slug') }} *</label>
                                            <input type="text" class="form-control" value="{{ $product->slug }}" required disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">{{ __('Branch') }} *</label>
                                            <input type="text" class="form-control" value="{{ $product->branch }}" required disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">{{ __('Categories') }} *</label>
                                            <input type="text" class="form-control" value="{{ implode(', ', $product->categories->pluck('name')->toArray()) }}" required disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">{{ __('Status') }} *</label>
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
                            <h3 class="k-portlet__head-title">{{ __('INVENTORY') }}</h3>
                        </div>
                    </div>

                    <div class="k-portlet__body">
                        @if ($inventory->id)
                        <div class="form-group">
                            <label for="">{{ __('FE Link') }} *</label>
                            <input
                                type="text"
                                name="slug"
                                class="form-control"
                                value="{{ route('fe.web.products.index', data_get($inventory, 'slug')) }}"
                                disabled
                            >
                        </div>
                        @endif

                        <div class="form-group">
                            <label for="">{{ __('Title') }} *</label>
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
                            <label for="">{{ __('Slug') }} *</label>
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
                                    <label for="">{{ __('Available From') }}
                                        <i
                                            data-toggle="tooltip"
                                            data-title="The date when the stock will be available. Default = immediately"
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
                                    <label for="">{{ __('Min Order Quantity') }}
                                        <i
                                            data-toggle="tooltip"
                                            class="flaticon-questions-circular-button"
                                            data-title="The quantity allowed to take orders. Must be an integer value. Default = 1"
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
                                    <label for="">{{ __('Condition Note') }}
                                        <i
                                            data-toggle="tooltip"
                                            class="flaticon-questions-circular-button"
                                            data-title="Input more details about the item condition. This will help customers to understand the item."
                                        ></i>
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="condition_note"
                                        value="{{ old('condition_note', data_get($inventory, 'condition_note')) }}"
                                    >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('Init Sold Count') }}
                                        <i
                                            data-toggle="tooltip"
                                            class="flaticon-questions-circular-button"
                                            data-title="{{ __('This sold count is for customer use only') }}"
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

                        <div class="row {{ $inventory->offer_price ? '' : 'd-none' }}" data-toggle-reference="offer_date_setup">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('Offer Start Date ') }}
                                        <i
                                            data-toggle="tooltip"
                                            class="flaticon-questions-circular-button"
                                            data-title="An offer must have a start date. Required if offer price field is given"
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
                                    <label for="">{{ __('Offer End Date ') }}
                                        <i
                                            data-toggle="tooltip"
                                            class="flaticon-questions-circular-button"
                                            data-title="An offer must have a start date. Required if offer price field is given"
                                        ></i>
                                    </label>
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
                            <h3 class="k-portlet__head-title">{{ __('VARIANTS') }}</h3>
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
                            <h3 class="k-portlet__head-title">{{ __('SIMPLE') }}</h3>
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
                            <h3 class="k-portlet__head-title">{{ __('KEY KEATURES') }}</h3>
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
                            <h3 class="k-portlet__head-title">{{ __('INFORMATION') }}</h3>
                        </div>
                    </div>
                    <div class="k-portlet__body">
                        <div class="form-group">
                            <label>{{ __('Meta Title') }}</label>
                            <input
                                type="text"
                                class="form-control {{ $errors->has('meta_title') ? 'is-invalid' : '' }}"
                                name="meta_title"
                                placeholder="{{ __('Enter Slug') }}"
                                value="{{ old('meta_title', $inventory->meta_title) }}"
                            >
                            @error('meta_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('Meta Description') }}</label>
                            <input
                                type="text"
                                class="form-control {{ $errors->has('meta_description') ? 'is-invalid' : '' }}"
                                name="meta_description"
                                placeholder="{{ __('Enter Slug') }}"
                                value="{{ old('meta_description', $inventory->meta_description) }}"
                            >
                            @error('meta_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label class="col-2 col-form-label">{{ __('FE Display') }}</label>
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
                            <label class="col-2 col-form-label">{{ __('FE Search') }}</label>
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
                            <label class="col-2 col-form-label">{{ __('Active') }}</label>
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
                            <h3 class="k-portlet__head-title">{{ __('PRODUCTS COMBO') }}</h3>
                        </div>
                    </div>

                    <div class="k-portlet__body">
                        @include('backoffice.pages.inventories.partials.product-combo')
                    </div>
                    @endif

                    <div class="k-portlet__foot">
                        <div class="k-form__actions d-flex justify-content-end">
                            <button type="redirect" class="btn btn-secondary mr-2">{{ __('Cancel') }}</button>
                            <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
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
{{-- <script src="{{ asset('backoffice/assets/demo/default/custom/components/forms/layouts/repeater.js') }}" type="text/javascript"></script> --}}
@include('backoffice.pages.inventories.js-pages.handle')
@include('backoffice.pages.inventories.js-pages.product-combos')
<script>
    $(document).ready(function() {
        FORM_MEDIA_IMAGE_PATH.triggerChange();
    });
</script>
@endsection
