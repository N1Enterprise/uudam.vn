@extends('backoffice.layouts.master')

@php
	$title = __('Chỉnh sửa biến thể');

	$breadcrumbs = [
		[
			'label' => __('Biến thể'),
		],
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
	<div class="row">
		<div class="col-md-12">

			<!--begin::Portlet-->
			<div class="k-portlet k-portlet--tabs">
				<div class="k-portlet__head">
					<div class="k-portlet__head-label">
						<h3 class="k-portlet__head-title">{{ __('Thông tin biến thể') }}</h3>
					</div>
					<div class="k-portlet__head-toolbar">
						<ul class="nav nav-tabs nav-tabs-bold nav-tabs-line nav-tabs-line-brand" role="tablist">
							<li class="nav-item">
								<a class="nav-link active show" data-toggle="tab" href="#mainTab" role="tab" aria-selected="true">
									{{ __('Thông tin chung') }}
								</a>
							</li>
						</ul>
					</div>
				</div>

				<!--begin::Form-->
				<form class="k-form" name="update_attribute_values" id="update_attribute_values" method="post" action="{{ route('bo.web.attribute-values.update', $attributeValue->id) }}">
					@csrf
                    @method('put')
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="tab-content">
							<div class="tab-pane active show" id="mainTab" role="tabpanel">
                                <div class="form-group">
                                    <label>{{ __('Thuộc tính') }} *</label>
                                    <select name="attribute_id" title="-- {{ __('Chọn thuộc tính') }} --" class="form-control k_selectpicker {{ $errors->has('attribute_id') ? 'is-invalid' : '' }}" required data-live-search="true">
                                        @foreach($attributes as $attribute)
                                        <option value="{{ $attribute->id }}" {{ old('attribute_id', $attributeValue->attribute_id) == $attribute->id ? 'selected' : '' }}>{{ $attribute->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('attribute_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

								<div class="form-group">
									<label>{{ __('Giá trị') }} *</label>
									<input type="text" class="form-control {{ $errors->has('value') ? 'is-invalid' : '' }}" name="value" placeholder="{{ __('Nhập giá trị') }}" value="{{ old('value', $attributeValue->value) }}" required>
                                    @error('value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
								</div>

                                <div class="form-group">
									<label>{{ __('Thứ tự') }}</label>
									<input type="number" class="form-control {{ $errors->has('order') ? 'is-invalid' : '' }}" name="order" placeholder="{{ __('Nhập thứ tự ưu tiên') }}" value="{{ old('order', $attributeValue->order) }}">
                                    @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
								</div>

								<div class="form-group row">
									<label class="col-2 col-form-label">{{ __('Hoạt động') }}</label>
									<div class="col-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ old('status', boolean($attributeValue->status) ? '1' : '0') == '1'  ? 'checked' : ''}} value="1" name="status"/>
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
							<button type="submit" class="btn btn-primary">{{ __('Lưu') }}</button>
							<button type="redirect" class="btn btn-secondary">{{ __('Huỷ') }}</button>
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
