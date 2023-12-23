@extends('backoffice.layouts.master')

@php
	$title = __('Home Page Display Item');

	$breadcrumbs = [
		[
			'label' => $title,
		],
		[
			'label' => __('Add Home Page Display Item'),
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
						<h3 class="k-portlet__head-title">{{ __('Add Home Page Display Item') }}</h3>
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
				<form class="k-form" name="form_home_page_display_item" id="form_home_page_display_item" method="post" action="{{ route('bo.web.home-page-display-items.store') }}">
					@csrf
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="tab-content">
							<div class="tab-pane active show" id="mainTab" role="tabpanel">
								<div class="form-group">
									<label>{{ __('Name') }} *</label>
									<input type="text" class="form-control" name="name" placeholder="{{ __('Enter Name') }}" value="{{ old('name') }}" required>
								</div>

                                <div class="form-group">
									<label>{{ __('Order') }}</label>
									<input type="number" class="form-control" name="order" placeholder="{{ __('Enter Order') }}" value="{{ old('order') }}">
								</div>

								<div class="form-group">
                                    <label>{{ __('Group') }} *</label>
                                    <select name="group_id" title="--{{ __('Select Group') }}--" data-toggle="tooltip" data-live-search="true" class="form-control k_selectpicker  {{ $errors->has('group_id') ? 'is-invalid' : '' }}" required>
                                        @foreach($groups as $cat)
                                        <option value="{{ $cat->id }}" {{ old('group_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('group_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

								<div class="form-group">
                                    <label>{{ __('Type') }} *</label>
									<select name="type" class="form-control" required>
										@foreach ($homePageDisplayTypeEnumLabels as $key => $label)
										<option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>{{ $label }}</option>
										@endforeach
									</select>
                                </div>

								<div data-type="1" class="d-none">
									<div class="form-group">
										<label>{{ __('Inventory') }} *</label>
										<select data-actions-box="true" name="linked_items[]" title="--{{ __('Select Inventories') }}--" data-size="5" data-live-search="true" class="form-control k_selectpicker Display_Inventory_Selector" multiple data-selected-text-format="count > 5">
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
										<div class="Display_Inventory_Holder_Content">
										</div>
									</div>
								</div>

								<div data-type="2" class="d-none">
									<div class="form-group">
										<label>{{ __('Collection') }} *</label>
										<select data-actions-box="true" name="linked_items[]" title="--{{ __('Select Collections') }}--" data-size="5" data-live-search="true" class="form-control k_selectpicker Display_Collection_Selector" multiple data-selected-text-format="count > 5">
											@foreach($collections as $collection)
											<option
												value="{{ $collection->id }}"
												data-tokens="{{ $collection->id }} | {{ $collection->title }} | {{ $collection->sku }}"
												data-slug="{{ $collection->slug }}"
												data-collection-id="{{ $collection->id }}"
												data-collection-name="{{ $collection->name }}"
												{{ in_array($collection->id, old('linked_items', [])) ? 'selected' : '' }}
											>{{ $collection->name }}</option>
											@endforeach
										</select>
									</div>
									<div class="form-group Display_Collection_Allowed_Holder mb-0">
										<div class="Display_Collection_Holder_Content">
										</div>
									</div>
								</div>

								<div class="form-group row">
									<label class="col-2 col-form-label">{{ __('Display On FE') }}</label>
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
									<label class="col-2 col-form-label">{{ __('Active') }}</label>
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
@include('backoffice.pages.home-page-display-items.js-pages.display-inventories')
@include('backoffice.pages.home-page-display-items.js-pages.display-collections')

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
