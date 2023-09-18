@extends('backoffice.layouts.master')

@php
	$title = __('Attribute');

	$breadcrumbs = [
		[
			'label' => $title,
		],
		[
			'label' => __('Add Attribute'),
		]
	];
@endphp

@section('header')
	{{ __($title) }}
@endsection

@component('backoffice.partials.breadcrumb', ['items' => $breadcrumbs]) @endcomponent

@section('content_body')

<div class="k-content__body	k-grid__item k-grid__item--fluid" id="k_content_body">
	<div class="row">
		<div class="col-md-6">

			<!--begin::Portlet-->
			<div class="k-portlet k-portlet--tabs">
				<div class="k-portlet__head">
					<div class="k-portlet__head-label">
						<h3 class="k-portlet__head-title">{{ __('Add Attribute') }}</h3>
					</div>
					<div class="k-portlet__head-toolbar">
						<ul class="nav nav-tabs nav-tabs-bold nav-tabs-line nav-tabs-line-brand" role="tablist">
							<li class="nav-item">
								<a class="nav-link active show" data-toggle="tab" href="#mainTab" role="tab" aria-selected="true">
									{{ __('Main') }}
								</a>
							</li>
						</ul>
					</div>
				</div>

				<!--begin::Form-->
				<form class="k-form" name="store_attributes" id="store_attributes" method="post" action="{{ route('bo.web.attributes.store') }}" enctype="multipart/form-data">
					@csrf
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="tab-content">
							<div class="tab-pane active show" id="mainTab" role="tabpanel">
								<div class="form-group">
									<label>{{ __('Name') }} *</label>
									<input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" placeholder="{{ __('Enter name') }}" value="{{ old('name') }}" required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
								</div>

                                <div class="form-group">
									<label>{{ __('Order') }}</label>
									<input type="number" class="form-control {{ $errors->has('order') ? 'is-invalid' : '' }}" name="order" placeholder="{{ __('Enter Order') }}" value="{{ old('order') }}">
                                    @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
								</div>

                                <div class="form-group">
                                    <label>{{ __('Attribute Type') }} *</label>
                                    <select name="attribute_type" title="--{{ __('Select Attribute Type') }}--" class="form-control k_selectpicker {{ $errors->has('attribute_type') ? 'is-invalid' : '' }}" required>
                                        @foreach($productAttributeTypeEnum as $key => $label)
                                        <option value="{{ $key }}" {{ old('attribute_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('attribute_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Categories') }}</label>
                                    <select name="categories[]" title="--{{ __('Select Cagegories') }}--" class="form-control k_selectpicker {{ $errors->has('categories') ? 'is-invalid' : '' }}" data-size="5" multiple>
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
