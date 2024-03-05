@extends('backoffice.layouts.master')

@php
	$title = __('Tạo phần tử hiển thị trang chủ');

	$breadcrumbs = [
		[
			'label' => __('Phần tử hiển thị trang chủ'),
		],
		[
			'label' => $title,
		],
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
						<h3 class="k-portlet__head-title">{{ __('Thông tin phần tử hiển thị') }}</h3>
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
				<form class="k-form" name="form_home_page_display_item" id="form_home_page_display_item" method="post" action="{{ route('bo.web.home-page-display-items.store') }}">
					@csrf
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="tab-content">
							<div class="tab-pane active show" id="mainTab" role="tabpanel">
								<div class="form-group">
									<label>{{ __('Tên') }} *</label>
									<input type="text" class="form-control" name="name" placeholder="{{ __('Nhập tên') }}" value="{{ old('name') }}" required>
								</div>

                                <div class="form-group">
									<label>{{ __('Thứ tự') }}</label>
									<input type="number" class="form-control" name="order" placeholder="{{ __('Nhập thứ tự ưu tiên') }}" value="{{ old('order') }}">
								</div>

								<div class="form-group">
                                    <label>{{ __('Nhóm') }} *</label>
                                    <select name="group_id" title="-- {{ __('Chọn nhóm') }} --" data-toggle="tooltip" data-live-search="true" class="form-control k_selectpicker  {{ $errors->has('group_id') ? 'is-invalid' : '' }}" required>
                                        @foreach($groups as $cat)
                                        <option value="{{ $cat->id }}" {{ old('group_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('group_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

								<div class="form-group">
                                    <label>{{ __('Loại') }} *</label>
									<select name="type" class="form-control" required>
										@foreach ($homePageDisplayTypeEnumLabels as $key => $label)
										<option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>{{ $label }}</option>
										@endforeach
									</select>
                                </div>

								<div data-type="1" class="d-none">
									<div class="form-group">
										<label>{{ __('Sản phẩm trong kho') }} *</label>
										<select data-actions-box="true" name="linked_items[]" title="-- {{ __('Chọn sản phẩm') }} --" data-size="5" data-live-search="true" class="form-control k_selectpicker Display_Inventory_Selector" multiple data-selected-text-format="count > 5">
											@foreach($inventories as $inventory)
											<option
												value="{{ $inventory->id }}"
												data-tokens="{{ $inventory->id }} | {{ $inventory->title }} | {{ $inventory->sku }}"
												data-slug="{{ $inventory->slug }}"
												data-inventory-id="{{ $inventory->id }}"
												data-inventory-name="{{ $inventory->title }}"
												{{ in_array($inventory->id, old('linked_items', [])) ? 'selected' : '' }}
											>{{ $inventory->title }} (SKU: {{ $inventory->sku }})</option>
											@endforeach
										</select>
									</div>
									<div class="form-group Display_Inventory_Allowed_Holder mb-0">
										<div class="Display_Inventory_Holder_Content"></div>
									</div>
								</div>

								<div data-type="2" class="d-none">
									<div class="form-group">
										<label>{{ __('Bộ sưu tập') }} *</label>
										<select data-actions-box="true" name="linked_items[]" title="-- {{ __('Chọn bộ sưu tập') }} --" data-size="5" data-live-search="true" class="form-control k_selectpicker Display_Collection_Selector" multiple data-selected-text-format="count > 5">
											@foreach($collections as $collection)
											<option
												value="{{ $collection->id }}"
												data-tokens="{{ $collection->id }} | {{ $collection->name }}}"
												data-slug="{{ $collection->slug }}"
												data-collection-id="{{ $collection->id }}"
												data-collection-name="{{ $collection->name }}"
												{{ in_array($collection->id, old('linked_items', [])) ? 'selected' : '' }}
											>{{ $collection->name }}</option>
											@endforeach
										</select>
									</div>
									<div class="form-group Display_Collection_Allowed_Holder mb-0">
										<div class="Display_Collection_Holder_Content"></div>
									</div>
								</div>

								<div data-type="3" class="d-none">
									<div class="form-group">
										<label>{{ __('Bài viết') }} *</label>
										<select data-actions-box="true" name="linked_items[]" title="-- {{ __('Chọn bài viết') }} --" data-size="5" data-live-search="true" class="form-control k_selectpicker Display_Post_Selector" multiple data-selected-text-format="count > 5">
											@foreach($posts as $post)
											<option
												value="{{ $post->id }}"
												data-tokens="{{ $post->id }} | {{ $post->name }}}"
												data-slug="{{ $post->slug }}"
												data-post-id="{{ $post->id }}"
												data-post-name="{{ $post->name }}"
												{{ in_array($post->id, old('linked_items', [])) ? 'selected' : '' }}
											>{{ $post->name }}</option>
											@endforeach
										</select>
									</div>
									<div class="form-group Display_Post_Allowed_Holder mb-0">
										<div class="Display_Post_Holder_Content"></div>
									</div>
								</div>

								<div data-type="4" class="d-none">
									<div class="form-group">
										<label>{{ __('Blogs') }} *</label>
										<select data-actions-box="true" name="linked_items[]" title="-- {{ __('Chọn Blogs') }} --" data-size="5" data-live-search="true" class="form-control k_selectpicker Display_Blog_Selector" multiple data-selected-text-format="count > 5">
											@foreach($postCategories as $postCategory)
											<option
												value="{{ $postCategory->id }}"
												data-tokens="{{ $postCategory->id }} | {{ $postCategory->name }}}"
												data-slug="{{ $postCategory->slug }}"
												data-post-category-id="{{ $postCategory->id }}"
												data-post-category-name="{{ $postCategory->name }}"
												{{ in_array($postCategory->id, old('linked_items', [])) ? 'selected' : '' }}
											>{{ $postCategory->name }}</option>
											@endforeach
										</select>
									</div>
									<div class="form-group Display_Blog_Allowed_Holder mb-0">
										<div class="Display_Blog_Holder_Content"></div>
									</div>
								</div>

								<div class="form-group row">
									<label class="col-2 col-form-label">{{ __('Hiển thị FE') }}</label>
									<div class="col-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ old('display_on_frontend') == '1'  ? 'checked' : ''}} value="1" name="display_on_frontend" />
												<span></span>
											</label>
										</span>
									</div>
								</div>

								<div class="form-group row">
									<label class="col-2 col-form-label">{{ __('Hoạt động') }}</label>
									<div class="col-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ old('status', '1') == '1'  ? 'checked' : ''}} value="1" name="status" />
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
@include('backoffice.pages.home-page-display-items.js-pages.display-inventories')
@include('backoffice.pages.home-page-display-items.js-pages.display-collections')
@include('backoffice.pages.home-page-display-items.js-pages.display-posts')
@include('backoffice.pages.home-page-display-items.js-pages.display-blogs')

<script>
	$(document).ready(function() {
		$('[name="type"]').on('change', function() {
			const val = $(this).val();

			$('[data-type]').addClass('d-none');
			$('[data-type]').find('[name="linked_items[]"]').selectpicker('val', []);
			$('[data-type]').find('[name="linked_items[]"]').prop('disabled', true);

			$(`[data-type="${val}"]`).removeClass('d-none');
			$(`[data-type="${val}"]`).find('[name="linked_items[]"]').prop('disabled', false);
		});

		$('[name="type"]').trigger('change');
	});
</script>
@endsection
