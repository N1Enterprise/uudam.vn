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

@section('style')
<style>
    .upload_image_custom_append_icon {
        top: 50%;
        right: 0;
        transform: translate(-6%, -50%);
        color: #4346ce!important;
        border: 1px solid #4346ce!important;
    }
    .note-toolbar-wrapper.panel-default {
        margin-bottom: 10px!important;
    }
    #form_builder_dom.styled {
        padding: 10px 35px;
        border: 1px solid #ebedf2;
        border-radius: 3px;
    }
    .ce-block__content,
    .ce-toolbar__content {
        max-width: unset!important;
    }
    .codex-editor__redactor {
        padding-bottom: 0px!important;
        min-height: 200px;
    }
</style>
@endsection

@section('content_body')
<div class="k-content__body	k-grid__item k-grid__item--fluid" id="k_content_body">
	<div class="row">
		<div class="col-md-6">

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
                                    <label>{{ __('Menu Type') }}</label>
                                    <div class="k-radio-inline">
                                        @foreach ($menuTypeEnumLabels as $key => $label)
                                        <label class="k-radio">
                                            <input type="radio" name="type" {{ (old('type', $menu->type) == $key ? 'checked' : $loop->index == 0 ? 'checked' : '') }} value="{{ $key }}"> {{ $label }}
                                            <span></span>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div data-menu-type-tab-key="1" data-menu-type="normal">
                                    <div class="form-group">
                                        <label>{{ __('Title') }}</label>
                                        <input type="text" class="form-control" name="meta[title]" placeholder="{{ __('Enter Menu Title') }}" value="{{ old('meta.title', data_get($menu->meta, 'title')) }}">
                                    </div>

                                    <div class="form-group">
                                        <label>{{ __('Redirect Url') }}</label>
                                        <input type="text" class="form-control" name="meta[redirect_url]" placeholder="{{ __('Enter Redirect Url') }}" value="{{ old('meta.redirect_url', data_get($menu->meta, 'redirect_url')) }}">
                                    </div>

                                    <div class="form-group">
                                        <label>{{ __('Image') }} *</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="upload_image_custom position-relative">
                                                    <input type="text" data-image-ref-path="primary" data-image-ref-index="0" class="form-control image_primary_image_url" name="meta[image][path]" value="{{ old('meta.image.path', data_get($menu->meta, 'image')) }}" placeholder="{{ __('Upload Image or Input URL') }}" style="padding-right: 104px;">
                                                    <div data-image-ref-wapper="primary" data-image-ref-index="0" class="d-none w-100 position-absolute d-none" style="top: 50%; left: 4px; transform: translateY(-50%); height: 90%; background-color: #fff;">
                                                        <div class="d-flex align-items-center h-100">
                                                            <img data-image-ref-img="primary" data-image-ref-index="0" src="" alt="Image preview" class="mr-2" style="height: 100%; width: 100px;">
                                                            <span data-image-ref-delete="primary" data-image-ref-index="0" aria-hidden="true" style="font-size: 16px; cursor: pointer;">&times;</span>
                                                        </div>
                                                    </div>
                                                    <label for="image_primary_image" class="btn position-absolute btn-secondary upload_image_custom_append_icon btn-sm d-flex">
                                                        <input type="file" id="image_primary_image" data-image-ref-path="file" data-image-ref-index="0" name="meta[image][file]" class="d-none image_primary_image_file">
                                                        <i class="flaticon2-image-file"></i>
                                                        <span>{{ __('Upload') }}</span>
                                                    </label>
                                                </div>
                                                <input type="hidden" class="form-control @anyerror('image, image.file, image.path') is-invalid @endanyerror">
                                                @anyerror('image, image.file, image.path')
                                                {{ $displayMessages() }}
                                                @endanyerror
                                            </div>
                                            <div class="col-md-6">
                                                <div class="image_primary_image_review">
                                                    <div data-image-ref-review-wapper="primary" data-image-ref-index="0" class="d-none" style="width: 100px; height: 100px; border: 1px solid #ccc;">
                                                        <img data-image-ref-review-img="primary" data-image-ref-index="0" style="width: 100%; height: 100%;" src="" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
									<label class="col-2 col-form-label">{{ __('Active') }}</label>
									<div class="col-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ old('status', boolean($menu->status) ? '1' : '0') == '1'  ? 'checked' : '' }} value="1" name="status"/>
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
@include('backoffice.pages.menus.js-pages.handle')
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
