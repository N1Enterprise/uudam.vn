@extends('backoffice.layouts.master')

@php
	$title = __('Tạo đánh giá');

	$breadcrumbs = [
		[
			'label' => __('Đánh giá sản phẩm'),
		],
		[
			'label' => $title
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
						<h3 class="k-portlet__head-title">{{ __('Thông tin đánh giá') }}</h3>
					</div>
					<div class="k-portlet__head-toolbar">
						<ul class="nav nav-tabs nav-tabs-bold nav-tabs-line nav-tabs-line-brand">
							<li class="nav-item">
								<a class="nav-link active show" data-toggle="tab" href="#mainTab">
									{{ __('Thông tin chung') }}
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
							<div class="tab-pane active show" id="mainTab">
								<div class="form-group">
									<label>{{ __('Tên khách hàng') }} *</label>
									<input type="text" class="form-control" name="user_name" placeholder="{{ __('Nhập tên khách hàng') }}" value="{{ old('user_name') }}" required>
								</div>

                                <div class="form-group">
									<label>{{ __('Số điện thoại') }}</label>
									<input type="text" class="form-control" name="user_phone" placeholder="{{ __('Nhập số điện thoại') }}" value="{{ old('user_phone') }}">
								</div>

                                <div class="form-group">
									<label>{{ __('E-mail') }}</label>
									<input type="text" class="form-control" name="user_email" placeholder="{{ __('Nhập e-mail') }}" value="{{ old('user_email') }}">
								</div>

                                <div class="form-group">
                                    <label>{{ __('Sản phẩm') }} *</label>
                                    <select name="product_id" title="-- {{ __('Chọn sản phẩm') }} --" class="form-control k_selectpicker" data-size="5" data-live-search="true">
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
                                    <label>{{ __('Loại xếp hạng') }} *</label>
                                    <select name="rating_type" title="-- {{ __('Chọn loại xếp hạng') }} --" class="form-control k_selectpicker">
                                        @foreach($productReviewRatingEnumLabels as $key => $label)
                                        <option value="{{ $key }}" {{ old('rating_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
									<label>{{ __('Nội dung') }} *
                                        <div><small>({{ __('Độ dài tối đa 1000 ký tự') }})</small></div>
                                    </label>

                                    <textarea name="content" rows="10" class="form-control" maxlength="1000" required>{{ old('content') }}</textarea>
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
