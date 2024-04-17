@extends('backoffice.layouts.master')

@php
	$title = __('Chỉnh sửa đánh giá');

	$breadcrumbs = [
		[
			'label' => __('Đánh giá sản phẩm'),
		],
		[
			'label' => $title
		]
	];

	$statusClass = 'alert-primary';

	switch ($productReview->status) {
		case enum('ProductReviewStatusEnum')::PENDING:
			$statusClass = 'alert-primary';
			break;
		case enum('ProductReviewStatusEnum')::APPROVED:
			$statusClass = 'alert-success';
			break;
		case enum('ProductReviewStatusEnum')::DECLINED:
			$statusClass = 'alert-danger';
			break;
		default:
			break;
	}
@endphp

@section('header')
	{{ __($title) }}
@endsection

@component('backoffice.partials.breadcrumb', ['items' => $breadcrumbs]) @endcomponent

@section('content_body')
<div class="k-content__body	k-grid__item k-grid__item--fluid" id="k_content_body">
	<div class="alert {{ $statusClass }}">
		<div class="alert-text">
			<span style="text-transform: uppercase; font-weight: bold;">{{ $productReview->status_name }}!</span>
		</div>
	</div>

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
				<form class="k-form" name="form_product_reviews" id="form_product_reviews" method="post" action="{{ route('bo.web.product-reviews.update', $productReview->id) }}">
					@csrf
                    @method('PUT')
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="tab-content">
							<div class="tab-pane active show" id="mainTab">
								<div class="form-group">
									<label>{{ __('Tên khách hàng') }} *</label>
									<input type="text" class="form-control" name="user_name" placeholder="{{ __('Nhập tên khách hàng') }}" value="{{ old('user_name', $productReview->user_name) }}" required {{ $productReview->is_real_user ? 'disabled' : '' }}>
								</div>

                                <div class="form-group">
									<label>{{ __('Số điện thoại') }}</label>
									<input type="text" class="form-control" name="user_phone" placeholder="{{ __('Nhập số điện thoại') }}" value="{{ old('user_phone', $productReview->user_phone) }}" {{ $productReview->is_real_user ? 'disabled' : '' }}>
								</div>

                                <div class="form-group">
									<label>{{ __('E-mail') }}</label>
									<input type="text" class="form-control" name="user_email" placeholder="{{ __('Nhập e-mail') }}" value="{{ old('user_email', $productReview->user_email) }}" {{ $productReview->is_real_user ? 'disabled' : '' }}>
								</div>

                                <div class="form-group">
                                    <label>{{ __('Sản phẩm') }} *</label>
                                    <select name="product_id" title="-- {{ __('Chọn sản phẩm') }} --" class="form-control k_selectpicker" data-size="5" data-live-search="true" {{ $productReview->is_real_user ? 'disabled' : '' }}>
                                        @foreach($categories as $category)
                                        <optgroup label="{{ $category->name }}">
                                            @foreach($category->products as $product)
                                            <option data-tokens="{{ $product->id }} | {{ $product->name }} | {{ $product->slug }}" value="{{ $product->id }}" {{ old('product_id', $productReview->product_id) == $product->id ? 'selected' : '' }} data-product-type="{{ $product->type }}">{{ $product->name }} ({{ $product->type_name }})</option>
                                            @endforeach
                                        </optgroup>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

									<div class="mt-3">
										<a href="{{ route('fe.web.products.index', data_get($productReview, 'product.slug')) }}" target="_blank" class="btn btn-outline-secondary btn-sm">{{ __('FE Review') }}</a>
										<a href="{{ route('bo.web.products.edit', data_get($productReview, 'product.id')) }}" target="_blank" class="btn btn-outline-secondary btn-sm">{{ __('BO Review') }}</a>
									</div>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Loại xếp hạng') }} *</label>
                                    <select name="rating_type" title="-- {{ __('Chọn loại xếp hạng') }} --" class="form-control k_selectpicker" {{ $productReview->is_real_user ? 'disabled' : '' }}>
                                        @foreach($productReviewRatingEnumLabels as $key => $label)
                                        <option value="{{ $key }}" {{ old('rating_type', $productReview->rating_type) == $key ? 'selected' : '' }}>{{ $label }}</option>
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

                                    <textarea name="content" rows="10" class="form-control" maxlength="1000" required {{ $productReview->is_real_user ? 'disabled' : '' }}>{{ old('content', $productReview->content) }}</textarea>
								</div>

                                <div class="form-group">
                                    <label>{{ __('Trạng thái') }} *</label>
                                    <input type="text" value="{{ $productReview->status_name }}" class="form-control" disabled>
                                </div>

                                <div class="form-group">
									<label>{{ __('Note') }}</label>
                                    <textarea name="note" rows="5" class="form-control">{{ old('note', $productReview->note) }}</textarea>
								</div>

                                <div class="form-group row">
									<label class="col-2 col-form-label">{{ __('Đã mua hàng') }}</label>
									<div class="col-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ boolean(old('is_purchased', $productReview->is_purchased))  ? 'checked' : ''}} value="1" name="is_purchased" />
												<span></span>
											</label>
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="k-portlet__foot d-flex justify-content-between">
						<div class="k-form__actions">
							<button type="redirect" class="btn btn-secondary">{{ __('Huỷ') }}</button>
							<button type="submit" class="btn btn-primary">{{ __('Lưu') }}</button>
						</div>
						<div class="k-form__actions">
							<button type="button" class="btn btn-danger" id="btn_decline" data-route="{{ route('bo.api.product-reviews.decline', $productReview->id) }}" {{ $productReview->isDeclined() ? 'disabled' : '' }}>{{ __('Decline') }}</button>
							<button type="button" class="btn btn-success" id="btn_approve" data-route="{{ route('bo.api.product-reviews.approve', $productReview->id) }}" {{ $productReview->isApproved() ? 'disabled' : '' }}>{{ __('Approve') }}</button>
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
<script>
    $('#btn_decline').on('click', function() {
		if (!confirm("{{ __('Are you sure to decline?') }}")) {
			return;
		}

		$.ajax({
			url: $(this).attr('data-route'),
			method: 'PUT',
			success: () => {
				location.reload();
			},
		});
	});

	$('#btn_approve').on('click', function() {
		if (!confirm("{{ __('Are you sure to approve?') }}")) {
			return;
		}

		$.ajax({
			url: $(this).attr('data-route'),
			method: 'PUT',
			success: () => {
				location.reload();
			},
		});
	});
</script>
@endsection
