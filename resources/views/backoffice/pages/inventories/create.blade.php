@extends('backoffice.layouts.master')

@php
	$title = __('Inventory');

	$breadcrumbs = [
		[
			'label' => $title,
		],
		[
			'label' => __('Add Inventory'),
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
    <form id="form_inventory" method="POST" action="{{ route('bo.web.inventories.store') }}" enctype="multipart/form-data">
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

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">{{ __('Product Name') }} *</label>
                                            <input type="text" class="form-control" value="{{ $product->name }}" required disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">{{ __('Product Code') }} *</label>
                                            <input type="text" class="form-control" value="{{ $product->code }}" required disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">{{ __('Product Slug') }} *</label>
                                            <input type="text" class="form-control" value="{{ $product->slug }}" required disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">{{ __('Product Branch') }} *</label>
                                            <input type="text" class="form-control" value="{{ $product->branch }}" required disabled>
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
                        <div class="form-group">
                            <label for="">{{ __('Title') }} *</label>
                            <input type="text" class="form-control" value="{{ old('title') }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('Available From') }}
                                        <i
                                            data-toggle="tooltip"
                                            class="flaticon-questions-circular-button"
                                            data-title="The date when the stock will be available. Default = immediately"
                                        ></i>
                                    </label>
                                    <input type="datetimepicker" required class="form-control @error('available_from') is-invalid @enderror" name="available_from" value="{{ old('available_from') }}">
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
                                    <input type="number" class="form-control" value="{{ old('min_order_quantity') }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">{{ __('Condition Note') }}
                                <i
                                    data-toggle="tooltip"
                                    class="flaticon-questions-circular-button"
                                    data-title="Input more details about the item condition. This will help customers to understand the item."
                                ></i>
                            </label>
                            <input type="text" class="form-control" value="{{ old('condition_note') }}">
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
                            <h3 class="k-portlet__head-title">{{ __('VARIANTS') }}</h3>
                        </div>
                    </div>
                    <div class="k-portlet__body">
                        @include('backoffice.pages.inventories.partials.variant')
                    </div>
                </div>
            </div>
        </div>

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
                            <label for="">{{ __('Description') }}</label>
                            <div id="form_builder_dom" class="styled"></div>
                            <input type="hidden" name="description" data-builder-ref="form_builder_dom" value="{{ old('description') }}">
                        </div>

                        <div class="form-group">
                            <label>{{ __('Meta Title') }}</label>
                            <input type="text" class="form-control {{ $errors->has('meta_title') ? 'is-invalid' : '' }}" name="meta_title" placeholder="{{ __('Enter Slug') }}" value="{{ old('meta_title') }}">
                            @error('meta_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('Meta Description') }}</label>
                            <input type="text" class="form-control {{ $errors->has('meta_description') ? 'is-invalid' : '' }}" name="meta_description" placeholder="{{ __('Enter Slug') }}" value="{{ old('meta_description') }}">
                            @error('meta_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

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
<script src="{{ asset('assets/vendors/general/jquery.repeater/src/lib.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/jquery.repeater/src/jquery.input.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/jquery.repeater/src/repeater.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/demo/default/custom/components/forms/layouts/repeater.js') }}" type="text/javascript"></script>
@include('backoffice.pages.inventories.js-pages.content-builder')
@include('backoffice.pages.inventories.js-pages.handle')
@endsection
