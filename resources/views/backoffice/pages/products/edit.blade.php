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

@endsection

@section('content_body')
<div class="k-content__body	k-grid__item k-grid__item--fluid" id="k_content_body">
	<div class="row">
		<div class="col-md-6">

			<!--begin::Portlet-->
			<div class="k-portlet k-portlet--tabs">
				<div class="k-portlet__head">
					<div class="k-portlet__head-label">
						<h3 class="k-portlet__head-title">{{ __('Add Product') }}</h3>
					</div>
					<div class="k-portlet__head-toolbar">
						<ul class="nav nav-tabs nav-tabs-bold nav-tabs-line nav-tabs-line-brand" role="tablist">
							<li class="nav-item">
								<a class="nav-link active show" data-toggle="tab" href="#tab_main" role="tab" aria-selected="true">
									{{ __('Main') }}
								</a>
							</li>

                            <li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#tab_organization" role="tab" aria-selected="true">
									{{ __('Organization') }}
								</a>
							</li>

                            <li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#tab_media" role="tab" aria-selected="true">
									{{ __('Media') }}
								</a>
							</li>
						</ul>
					</div>
				</div>

				<!--begin::Form-->
				<form class="k-form" name="store_category_group" id="store_category_group" method="post" action="{{ route('bo.web.products.store') }}" enctype="multipart/form-data">
					@csrf
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="tab-content">
							<div class="tab-pane active show" id="tab_main" role="tabpanel">
                                <div class="form-group">
                                    <label>{{ __('Name') }} *</label>
                                    <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" placeholder="{{ __('Enter name') }}" value="{{ old('name') }}" required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Code') }} *</label>
                                    <input type="text" class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" name="code" placeholder="{{ __('Enter code') }}" value="{{ old('code') }}" required>
                                    @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Slug') }} *</label>
                                    <input type="text" class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" name="slug" placeholder="{{ __('Enter slug') }}" value="{{ old('slug') }}" required>
                                    @error('slug')
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
                                </div>

                                <div class="form-group">
									<label>{{ __('Description') }}</label>
                                    <textarea unselectable="on" name="description" rows="3" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}">{{ old('description') }}</textarea>
                                    @error('min_amount')
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
                            <div class="tab-pane" id="tab_organization" role="tabpanel">
                                <div class="form-group">
                                    <label>{{ __('Branch') }}</label>
                                    <input type="text" class="form-control {{ $errors->has('branch') ? 'is-invalid' : '' }}" name="branch" placeholder="{{ __('Enter branch') }}" value="{{ old('branch') }}">
                                    @error('branch')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

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
                                </div>

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
                            <div class="tab-pane" id="tab_media" role="tabpanel">
                                <div class="form-group">
                                    <label>{{ __('Primary Image') }}</label>
                                    <div class="upload_image_custom position-relative">
                                        <input type="text" class="form-control message_content_primary_image_url" placeholder="{{ __('Upload Image or Input URL') }}" style="padding-right: 104px;">
                                        <div class="message_content_primary_image_preview_on_input_wrapper d-none w-100 position-absolute d-none" style="top: 50%; left: 4px; transform: translateY(-50%); height: 90%; background-color: #fff;">
                                            <div class="message_content_primary_image_preview_on_input d-flex align-items-center h-100">
                                                <img src="" alt="Image preview" class="mr-2" style="height: 100%; width: 100px;">
                                                <span aria-hidden="true" class="remove_message_content_primary_image_preview_on_input" style="font-size: 16px; cursor: pointer;">&times;</span>
                                            </div>
                                        </div>
                                        <label for="message_content_primary_image" class="btn position-absolute btn-secondary upload_image_custom_append_icon btn-sm d-flex">
                                            <input type="file" id="message_content_primary_image" name="message_content[primary_image]" class="d-none message_content_primary_image_file">
                                            <i class="flaticon2-image-file"></i>
                                            <span>{{ __('Upload') }}</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
						</div>
					</div>
					<div class="k-portlet__foot">
						<div class="k-form__actions">
							<button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
							<button type="redirect" class="btn btn-secondary">{{ __('Cancel') }}</button>
						</div>
					</div>
				</form>

				<!--end::Form-->
			</div>
		</div>
	</div>
</div>
@endsection

@section('js_script')

@endsection
