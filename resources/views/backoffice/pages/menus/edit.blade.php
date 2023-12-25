@extends('backoffice.layouts.master')

@php
	$title = __('Menu');

	$breadcrumbs = [
		[
			'label' => $title,
		],
		[
			'label' => __('Edit Menu'),
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
						<h3 class="k-portlet__head-title">{{ __('Edit Menu') }}</h3>
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
				<form class="k-form" name="form_menus" id="form_menus" method="post" action="{{ route('bo.web.menus.update', $menu->id) }}" enctype="multipart/form-data">
					@csrf
                    @method('PUT')
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="tab-content">
							<div class="tab-pane active show" id="mainTab" role="tabpanel">
								<div class="form-group">
									<label>{{ __('Name') }} *</label>
									<input type="text" class="form-control" name="name" placeholder="{{ __('Enter name') }}" value="{{ old('name', $menu->name) }}" required>
								</div>

                                <div class="form-group">
									<label>{{ __('Order') }}</label>
									<input type="number" class="form-control" name="order" placeholder="{{ __('Enter Order') }}" value="{{ old('order', $menu->order) }}">
								</div>

                                <div class="form-group">
                                    <label>{{ __('Menu Type') }} *</label>
									<input type="hidden" name="type" value="{{ $menu->type }}">
                                    <div class="k-radio-inline">
										<select class="form-control" disabled>
											@foreach ($menuTypeEnumLabels as $key => $label)
											<option value="{{ $key }}" {{ (old('type', $menu->type) == $key ? 'selected' : $loop->index == 0 ? 'selected' : '') }}>{{ $label }}</option>
											@endforeach
										</select>
                                    </div>
                                </div>

                                <div data-menu-type-tab-key="1" data-menu-type="Collection">
                                    <div class="form-group">
                                        <label>{{ __('Collection') }} *</label>
                                        <select name="collection_id" title="--{{ __('Select Collection') }}--" class="form-control k_selectpicker" data-live-search="true">
                                            @foreach($collections as $collection)
                                            <option value="{{ $collection->id }}" data-slug="{{ $collection->slug }}" {{ old('collection_id', $collection->id) == $collection->id ? 'selected' : '' }}>{{ $collection->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('collection_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div data-menu-type-tab-key="2" data-menu-type="Inventory" class="d-none">
                                    <div class="form-group">
                                        <label>{{ __('Inventory') }} *</label>
                                        <select name="inventory_id" title="--{{ __('Select Inventory') }}--" class="form-control k_selectpicker" data-live-search="true">
                                            @foreach($inventories as $inventory)
                                            <option value="{{ $inventory->id }}" data-slug="{{ $inventory->slug }}" {{ old('inventory_id', $menu->inventory_id) == $inventory->id ? 'selected' : '' }}>{{ $inventory->title }} (SKU: {{ $inventory->sku }})</option>
                                            @endforeach
                                        </select>
                                        @error('inventory_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div data-menu-type-tab-key="3" data-menu-type="Post" class="d-none">
                                    <div class="form-group">
                                        <label>{{ __('Post') }} *</label>
                                        <select name="post_id" title="--{{ __('Select Post') }}--" class="form-control k_selectpicker" data-live-search="true">
                                            @foreach($posts as $post)
                                            <option value="{{ $post->id }}" data-slug="{{ $post->slug }}" {{ old('post_id', $menu->post_id) == $post->id ? 'selected' : '' }}>{{ $post->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('post_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Groups') }} *</label>
                                    <select name="menu_catalogs[]" title="--{{ __('Select Group') }}--" class="form-control k_selectpicker" data-size="5" multiple required>
                                        @foreach($menuGroups as $menuGroup)
                                        <optgroup label="{{ $menuGroup->name }}">
                                            @foreach($menuGroup->menuSubGroups as $subGroup)
                                            <option value="{{ $subGroup->id }}" {{ in_array($subGroup->id, old('menu_catalogs', $menu->menuCatalogs->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $subGroup->name }}</option>
                                            @endforeach
                                        </optgroup>
                                        @endforeach
                                    </select>
                                    @error('menu_catalogs')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group row">
									<label class="col-2 col-form-label">{{ __('Is New') }}</label>
									<div class="col-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ old('is_new', boolean($menu->is_new) ? '1' : '0') == '1'  ? 'checked' : '' }} value="1" name="is_new"/>
												<span></span>
											</label>
										</span>
									</div>
								</div>

                                <div class="form-group row">
									<label class="col-2 col-form-label">{{ __('FE Display') }}</label>
									<div class="col-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ old('display_on_frontend', boolean($menu->display_on_frontend)) == '1'  ? 'checked' : ''}} value="1" name="display_on_frontend" />
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
												<input type="checkbox" {{ old('status', boolean($menu->status)) == '1'  ? 'checked' : '' }} value="1" name="status"/>
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
    onChangeMenuType();

    function onChangeMenuType() {
        $('[name="type"]').on('change', function() {
            const type = $(this).val();
            $('[data-menu-type-tab-key]').addClass('d-none');
            $(`[data-menu-type-tab-key="${type}"]`).removeClass('d-none');
        });
    }
    FORM_PRIMARY_IMAGE_PATH.triggerChange();
</script>
@endsection
