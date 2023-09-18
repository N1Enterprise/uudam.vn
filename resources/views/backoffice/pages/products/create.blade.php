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
    .languages_selection {
        width: 50rem;
        flex-wrap: wrap;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        padding: 1rem 1.5rem;
        max-height: 400px;
    }
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
    #campaign_message_review .campaign_message_review__title {
        font-size: 2rem;
        line-height: 30px;
        font-weight: 600;
        color: #3d4465;
        margin-bottom: 20px;
    }

    #campaign_message_review .campaign_message_review__content {
        width: 100%;
        margin-top: 0.75rem;
        position: relative;
    }

    #campaign_message_review .campaign_message_review__content {
        font-size: .875rem;
        line-height: 1.25rem;
        all: initial;
    }

    #campaign_message_review .campaign_message_review__content .content__image {
        width: 100%;
        height: auto;
        border-radius: 0.25rem;
        margin-bottom: 20px;
    }
    .campaign_message_review_wrapper {
        cursor: pointer;
        background: #fafafa;
        padding: 20px;
        border-radius: 5px;
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
    .form_builder_card {
        min-height: 110px;
    }
    .builder_html_iframe {
        height: 100%;
        width: 100%;
        top: 0px;
    }
</style>
@endsection

@section('content_body')
<div class="k-content__body	k-grid__item k-grid__item--fluid" id="k_content_body">
	<form action="">
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
                            <label for="">{{ __('Name') }}</label>
                            <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="{{ __('Enter Name') }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('Code') }}</label>
                                    <input type="text" name="code" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="{{ __('Enter Code') }}">
                                    @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('Slug') }}</label>
                                    <input type="text" name="slug" class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" placeholder="{{ __('Enter Slug') }}">
                                    @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Primary Image') }}</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="upload_image_custom position-relative">
                                        <input type="text" class="form-control image_primary_image_url" name="image_primary_image_path" placeholder="{{ __('Upload Image or Input URL') }}" style="padding-right: 104px;">
                                        <div data-image-ref-wapper="primary" data-image-ref-index="0" class="d-none w-100 position-absolute d-none" style="top: 50%; left: 4px; transform: translateY(-50%); height: 90%; background-color: #fff;">
                                            <div class="d-flex align-items-center h-100">
                                                <img data-image-ref-img="primary" data-image-ref-index="0" src="" alt="Image preview" class="mr-2" style="height: 100%; width: 100px;">
                                                <span aria-hidden="true" style="font-size: 16px; cursor: pointer;">&times;</span>
                                            </div>
                                        </div>
                                        <label for="image_primary_image" class="btn position-absolute btn-secondary upload_image_custom_append_icon btn-sm d-flex">
                                            <input type="file" id="image_primary_image" name="image_primary_image_file" class="d-none image_primary_image_file">
                                            <i class="flaticon2-image-file"></i>
                                            <span>{{ __('Upload') }}</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="image_primary_image_review">
                                        <div data-image-ref-review-wapper="primary" data-image-ref-review-index="0" class="d-none" style="width: 100px; height: 100px; border: 1px solid #ccc;">
                                            <img data-image-ref-review-img="primary" data-image-ref-review-index="0" style="width: 100%; height: 100%;" src="" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">{{ __('Media') }}</label>
                            <div class="k-repeater">
                                <div data-repeater-list="demo1">
                                    <div data-repeater-item class="k-repeater__item">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="upload_image_custom position-relative">
                                                    <input type="text" class="form-control media_image_url" placeholder="{{ __('Upload Image or Input URL') }}" style="padding-right: 104px;">
                                                    <div class="media_image_preview_on_input_wrapper d-none w-100 position-absolute d-none" style="top: 50%; left: 4px; transform: translateY(-50%); height: 90%; background-color: #fff;">
                                                        <div class="media_image_preview_on_input d-flex align-items-center h-100">
                                                            <img src="" alt="Image preview" class="mr-2" style="height: 100%; width: 100px;">
                                                            <span aria-hidden="true" class="remove_media_image_preview_on_input" style="font-size: 16px; cursor: pointer;">&times;</span>
                                                        </div>
                                                    </div>
                                                    <label for="media_image" class="btn position-absolute btn-secondary upload_image_custom_append_icon btn-sm d-flex">
                                                        <input type="file" name="form[primary_image]" class="d-none media_image_file">
                                                        <i class="flaticon2-image-file"></i>
                                                        <span>{{ __('Upload') }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" data-repeater-delete class="btn btn-secondary btn-icon h-100">
                                                    <i class="la la-close"></i>
                                                </button>
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
                            <label>{{ __('Cagegories') }} *</label>
                            <select name="categories[]" title="--{{ __('Select Cagegories') }}--" class="form-control k_selectpicker" data-size="5" multiple required>
                                @foreach($categoryGroups as $categoryGroup)
                                <optgroup label="{{ $categoryGroup->name }}">
                                    @foreach($categoryGroup->categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                                <option value="{{ $key }}">{{ $label }}</option>
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
