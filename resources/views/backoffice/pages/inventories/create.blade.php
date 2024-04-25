@extends('backoffice.layouts.master')

@php
	$title = __('Sản phẩm tồn kho');

    $action = empty($inventory->id) ? __('Tạo') : __('Chỉnh sửa');

	$breadcrumbs = [
		[
			'label' => $title,
		],
		[
			'label' => __("{$action} sản phẩm kho"),
		]
	];
@endphp

@section('header')
{{ __($title) }}
@endsection

@section('style')
@include('backoffice.pages.inventories.style-pages.common')
@endsection

@component('backoffice.partials.breadcrumb', ['items' => $breadcrumbs]) @endcomponent

@section('content_body')
<div class="k-content__body	k-grid__item k-grid__item--fluid" id="k_content_body">
    <form id="form_inventory" method="POST" action="{{ empty($inventory->id) ? route('bo.web.inventories.store') : route('bo.web.inventories.update', $inventory->id) }}" enctype="multipart/form-data">
        @csrf
        @error('*')
        <div class="alert alert-danger fade show">
            <div class="alert-text">
                {{ __('Gửi không thành công. Vui lòng kiểm tra lỗi bên dưới.') }}
            </div>
            <div class="alert-close">
                <button type="button" class="close" data-dismiss="alert">
                    <span><i class="la la-close"></i></span>
                </button>
            </div>
        </div>
        @enderror
        @if(! empty($inventory->id)) @method('PUT') @endif
        <input type="hidden" id="INVENTORY_DATA" value='@json($inventory)' data-is-edit="{{ boolean(! empty($inventory->id)) }}">

        <div class="k-portlet__head-toolbar">
            <ul class="nav nav-tabs nav-tabs-bold nav-tabs-line nav-tabs-line-brand d-flex">
                <li class="nav-item">
                    <a class="nav-link active show" data-toggle="tab" href="#Tag_General_Information">
                        {{ __('Thông tin chung') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#Tab_Classification_Group">
                        {{ __('Nhóm phân loại') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#Tab_SEO">
                        {{ __('Thông tin SEO') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#Tab_Description_Information">
                        {{ __('Thông tin mô tả') }}
                    </a>
                </li>
            </ul>
        </div>

        <div class="tab-content">
            <div class="tab-pane active show" id="Tag_General_Information">
                @include('backoffice.pages.inventories.partials.tab-general-information')
            </div>

            <div class="tab-pane" id="Tab_Classification_Group">
                @include('backoffice.pages.inventories.partials.tab-classification-group')
            </div>

            <div class="tab-pane" id="Tab_SEO">
                @include('backoffice.pages.inventories.partials.tab-seo')
            </div>

            <div class="tab-pane" id="Tab_Description_Information">
                @include('backoffice.pages.inventories.partials.tab-description-information')
            </div>
        </div>

        <div class="k-portlet__foot">
            <div class="k-form__actions d-flex justify-content-end">
                <button type="redirect" class="btn btn-secondary mr-2">{{ __('Huỷ') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('Lưu') }}</button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('js_script')
<script src="{{ asset('backoffice/assets/vendors/general/jquery.repeater/src/lib.js') }}" type="text/javascript"></script>
<script src="{{ asset('backoffice/assets/vendors/general/jquery.repeater/src/jquery.input.js') }}" type="text/javascript"></script>
<script src="{{ asset('backoffice/assets/vendors/general/jquery.repeater/src/repeater.js') }}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.4/ace.js" type="text/javascript"></script>
@include('backoffice.pages.inventories.js-pages.handle')
@include('backoffice.pages.inventories.js-pages.product-combos')
<script>
    $(document).ready(function() {
        FORM_MEDIA_IMAGE_PATH.triggerChange();
        VARIANT_BORDER_IMAGE_IMAGE_PATH.triggerChange();
    });

    $(document).ready(function () {
        let editorMeta = ace.edit($('#json_editor_meta')[0], {
            mode: "ace/mode/json",
            theme: 'ace/theme/tomorrow',
            value: $(`input[name="meta"]`).val()
        });

        $('form#form_inventory').on('submit', function(e) {
            e.preventDefault();
            let editorMetaElement = $(`input[name="meta"]`).val(editorMeta.getValue());
            $(this).append(editorMetaElement);
            $(this)[0].submit();
        });
    });
</script>
@endsection
