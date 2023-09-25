@extends('backoffice.layouts.master')

@php
	$title = __('Product');

	$breadcrumbs = [
		[
			'label' => $title,
		],
		[
			'label' => __('Add Product'),
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
    .note-toolbar-wrapper.panel-default {
        margin-bottom: 10px!important;
    }
    #form_builder_dom.styled {
        padding: 10px 35px;
        border: 1px solid #ebedf2;
        border-radius: 3px;
    }
    .ce-block__content,
    .ce-toolbar__content {
        max-width: unset!important;
    }
    .codex-editor__redactor {
        padding-bottom: 0px!important;
        min-height: 200px;
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
            <div class="col-md-8">
                <div class="k-portlet">
                    <div class="k-portlet__head">
                        <div class="k-portlet__head-label">
                            <h3 class="k-portlet__head-title">{{ __('GENERAL') }}</h3>
                        </div>
                    </div>
                    <div class="k-portlet__body">
                        <div class="form-group">
                            <label for="">{{ __('Name') }} *</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="{{ __('Enter Name') }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('Code') }} *</label>
                                    <input type="text" name="code" value="{{ old('code') }}" class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" placeholder="{{ __('Enter Code') }}" required>
                                    @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('Slug') }} *</label>
                                    <input type="text" name="slug" value="{{ old('slug') }}" class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" placeholder="{{ __('Enter Slug') }}" required>
                                    @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Primary Image') }} *</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="upload_image_custom position-relative">
                                        <input type="text" data-image-ref-path="primary" data-image-ref-index="0" class="form-control image_primary_image_url" name="primary_image[path]" placeholder="{{ __('Upload Image or Input URL') }}" style="padding-right: 104px;">
                                        <div data-image-ref-wapper="primary" data-image-ref-index="0" class="d-none w-100 position-absolute d-none" style="top: 50%; left: 4px; transform: translateY(-50%); height: 90%; background-color: #fff;">
                                            <div class="d-flex align-items-center h-100">
                                                <img data-image-ref-img="primary" data-image-ref-index="0" src="" alt="Image preview" class="mr-2" style="height: 100%; width: 100px;">
                                                <span data-image-ref-delete="primary" data-image-ref-index="0" aria-hidden="true" style="font-size: 16px; cursor: pointer;">&times;</span>
                                            </div>
                                        </div>
                                        <label for="image_primary_image" class="btn position-absolute btn-secondary upload_image_custom_append_icon btn-sm d-flex">
                                            <input type="file" id="image_primary_image" data-image-ref-path="file" data-image-ref-index="0" name="primary_image[file]" class="d-none image_primary_image_file">
                                            <i class="flaticon2-image-file"></i>
                                            <span>{{ __('Upload') }}</span>
                                        </label>
                                    </div>
                                    <input type="hidden" class="form-control @anyerror('primary_image, primary_image.file, primary_image.path') is-invalid @endanyerror">
                                    @anyerror('primary_image, primary_image.file, primary_image.path')
                                    {{ $displayMessages() }}
                                    @endanyerror
                                </div>
                                <div class="col-md-6">
                                    <div class="image_primary_image_review">
                                        <div data-image-ref-review-wapper="primary" data-image-ref-index="0" class="d-none" style="width: 100px; height: 100px; border: 1px solid #ccc;">
                                            <img data-image-ref-review-img="primary" data-image-ref-index="0" style="width: 100%; height: 100%;" src="" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">{{ __('Media') }}</label>
                            <div class="media_image_repeater">
                                <div data-repeater-list="media[image]">
                                    <div data-repeater-item class="k-repeater__item">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="upload_image_custom position-relative">
                                                    <input type="text" data-image-ref-path="media" data-image-ref-index="0" class="form-control media_image_path" name="path" placeholder="{{ __('Upload Image or Input URL') }}" style="padding-right: 104px;" value="{{ old('primary_image.path') }}">
                                                    <div data-image-ref-wapper="media" data-image-ref-index="0" class="d-none w-100 position-absolute d-none" style="top: 50%; left: 4px; transform: translateY(-50%); height: 90%; background-color: #fff;">
                                                        <div class="d-flex align-items-center h-100">
                                                            <img data-image-ref-img="media" data-image-ref-index="0" src="" alt="Image preview" class="mr-2" style="height: 100%; width: 100px;">
                                                            <span data-image-ref-delete="media" data-image-ref-index="0" aria-hidden="true" style="font-size: 16px; cursor: pointer;">&times;</span>
                                                        </div>
                                                    </div>
                                                    <label for="media_image" class="media_image_file_wapper btn position-absolute btn-secondary upload_image_custom_append_icon btn-sm d-flex">
                                                        <input type="file" name="file" data-image-ref-file="media" data-image-ref-index="0" class="d-none media_image_file">
                                                        <i class="flaticon2-image-file"></i>
                                                        <span>{{ __('Upload') }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-start">
                                                    <button type="button" data-repeater-delete class="btn btn-secondary btn-icon h-100 mr-2" style="width: 30px!important; height: 30px!important;">
                                                        <i class="la la-close"></i>
                                                    </button>
                                                    <div class="image_media_image_review">
                                                        <div data-image-ref-review-wapper="media" data-image-ref-index="0" class="d-none" style="width: 100px; height: 100px; border: 1px solid #ccc;">
                                                            <img data-image-ref-review-img="media" data-image-ref-index="0" style="width: 100%; height: 100%;" src="" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="k-separator k-separator--space-sm"></div>
                                    </div>
                                </div>
                                <div class="k-repeater__add-data">
                                    <span data-repeater-create="" class="btn btn-info btn-sm">
                                        <i class="la la-plus"></i> {{ __('Add') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">{{ __('Description') }}</label>
                            <div id="form_builder_dom" class="styled"></div>
                            <input type="hidden" name="description" data-builder-ref="form_builder_dom" value="{{ old('description') }}">
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
            <div class="col-md-4">
                <div class="k-portlet">
                    <div class="k-portlet__head">
                        <div class="k-portlet__head-label">
                            <h3 class="k-portlet__head-title">{{ __('ORGANIZATION') }}</h3>
                        </div>
                    </div>
                    <div class="k-portlet__body">
                        <div class="form-group">
                            <label>{{ __('Categories') }} *</label>
                            <select name="categories[]" title="--{{ __('Select Cagegories') }}--" class="form-control k_selectpicker" data-size="5" multiple required>
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
                            <label>{{ __('Product Type') }} *</label>
                            <select name="type" title="--{{ __('Select Product Type') }}--" class="form-control k_selectpicker">
                                @foreach($productTypeLabels as $key => $label)
                                <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Min Amount') }} *</label>
                                    <x-number-input
                                        key="min_amount"
                                        name="min_amount"
                                        class="form-control {{ $errors->has('min_amount') ? 'is-invalid' : '' }}"
                                        allow-minus="false"
                                        value="{{ old('min_amount') }}"
                                        required
                                    />
                                    @error('min_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Max Amount') }}</label>
                                    <x-number-input
                                        key="max_amount"
                                        name="max_amount"
                                        class="form-control {{ $errors->has('max_amount') ? 'is-invalid' : '' }}"
                                        allow-minus="false"
                                        value="{{ old('max_amount') }}"
                                    />
                                    @error('max_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Branch') }}</label>
                            <input type="text" class="form-control {{ $errors->has('branch') ? 'is-invalid' : '' }}" name="branch" placeholder="{{ __('Enter branch') }}" value="{{ old('branch') }}">
                            @error('branch')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label class="col-2 col-form-label">{{ __('Active') }}</label>
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
        </div>
    </form>
</div>
@endsection

@section('js_script')
<script src="{{ asset('assets/vendors/general/jquery.repeater/src/lib.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/jquery.repeater/src/jquery.input.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/jquery.repeater/src/repeater.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/demo/default/custom/components/forms/layouts/repeater.js') }}" type="text/javascript"></script>
@include('backoffice.pages.products.js-pages.content-builder')
@include('backoffice.pages.products.js-pages.handle')
@endsection
