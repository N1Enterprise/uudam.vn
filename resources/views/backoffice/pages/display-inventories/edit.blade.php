@extends('backoffice.layouts.master')

@php
	$title = __('Display Inventory');

	$breadcrumbs = [
		[
			'label' => $title,
		],
		[
			'label' => __('Edit Display Inventory'),
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
						<h3 class="k-portlet__head-title">{{ __('Edit Display Inventory') }}</h3>
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
				<form class="k-form" name="form_display_inventories" id="form_display_inventories" method="post" action="{{ route('bo.web.display-inventories.update', $displayInventory->id) }}">
					@csrf
                    @method('PUT')
                    <input type="hidden" name="type" value="{{ $type }}">
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="tab-content">
							<div class="tab-pane active show" id="mainTab" role="tabpanel">
                                <div class="form-group">
                                    <label>{{ __('Inventory') }} *</label>
                                    <select name="inventory_id" title="--{{ __('Select Inventory') }}--" class="form-control k_selectpicker">
                                        @foreach($inventories as $inventory)
                                        <option value="{{ $inventory->id }}" data-slug="{{ $inventory->slug }}" {{ old('inventory_id', $displayInventory->inventory_id) == $inventory->id ? 'selected' : '' }}>{{ $inventory->title }} (SKU: {{ $inventory->sku }})</option>
                                        @endforeach
                                    </select>
                                    @error('inventory_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
									<label>
                                        {{ __('Redirect URL') }}
                                        <small>({{ __('Default used default product url') }})</small>
                                    </label>
									<input type="text" class="form-control" name="redirect_url" placeholder="{{ __('Enter Redirect URL') }}" value="{{ old('redirect_url', $displayInventory->redirect_url) }}" required>
								</div>

                                <div class="form-group">
									<label>{{ __('Order') }}</label>
									<input type="number" class="form-control" name="order" placeholder="{{ __('Enter Order') }}" value="{{ old('order', $displayInventory->order) }}">
								</div>

								<div class="form-group row">
									<label class="col-2 col-form-label">{{ __('Active') }}</label>
									<div class="col-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ old('status', boolean($displayInventory->status) ? '1' : '0') == '1'  ? 'checked' : ''}} value="1" name="status" />
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
<script>
    onInventoryChange();

    function onInventoryChange() {
        $('[name="inventory_id"]').on('change', function() {
            const slug = $(this).find(`option[value="${$(this).val()}"]`).attr('data-slug');
            const productRoute = "{{ route('fe.web.products.index', ':slug') }}".replace(':slug', slug);

            $('[name="redirect_url"]').val(slug ? productRoute : '');
        });
    }
</script>
@endsection
