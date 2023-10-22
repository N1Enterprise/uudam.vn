@extends('backoffice.layouts.master')

@php
	$title = __('Product Review');

	$breadcrumbs = [
		[
			'label' => $title,
		],
		[
			'label' => __('Add Product Review'),
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
						<h3 class="k-portlet__head-title">{{ __('Add Product Review') }}</h3>
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
				<form class="k-form" name="form_product_reviews" id="form_product_reviews" method="post" action="{{ route('bo.web.product-reviews.store') }}">
					@csrf
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="tab-content">
							<div class="tab-pane active show" id="mainTab" role="tabpanel">
								<div class="form-group">
									<label>{{ __('User Name') }} *</label>
									<input type="text" class="form-control" name="user_name" placeholder="{{ __('Enter user name') }}" value="{{ old('user_name') }}" required>
								</div>

                                <div class="form-group">
									<label>{{ __('User Phone') }}</label>
									<input type="text" class="form-control" name="user_phone" placeholder="{{ __('Enter user phone') }}" value="{{ old('user_phone') }}">
								</div>

                                <div class="form-group">
									<label>{{ __('User Email') }}</label>
									<input type="text" class="form-control" name="user_email" placeholder="{{ __('Enter user email') }}" value="{{ old('user_email') }}">
								</div>

                                <div class="form-group">
                                    <label>{{ __('Product') }} *</label>
                                    <select name="product_id" title="--{{ __('Select Product') }}--" class="form-control k_selectpicker" data-size="5" data-live-search="true">
                                        @foreach($categories as $category)
                                        <optgroup label="{{ $category->name }}">
                                            @foreach($category->products as $product)
                                            <option  data-tokens="{{ $product->id }} | {{ $product->name }} | {{ $product->slug }}" value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }} data-product-type="{{ $product->type }}">{{ $product->name }} ({{ $product->type_name }})</option>
                                            @endforeach
                                        </optgroup>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Rating Type') }} *</label>
                                    <select name="rating_type" title="--{{ __('Select Rating Type') }}--" class="form-control k_selectpicker">
                                        @foreach($productReviewRatingEnumLabels as $key => $label)
                                        <option value="{{ $key }}" {{ old('rating_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
									<label>{{ __('Content') }} *
                                        <div><small>({{ __('Max length 1000 charactors') }})</small></div>
                                    </label>

                                    <textarea name="content" rows="10" class="form-control" maxlength="1000" required>{{ old('content') }}</textarea>
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
