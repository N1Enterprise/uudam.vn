@extends('backoffice.layouts.master')

@php
	$title = __('Banner');

	$breadcrumbs = [
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
    <div class="k-portlet k-portlet--mobile">
        <div class="k-portlet__head">
            <div class="k-portlet__head-label">
                <h3 class="k-portlet__head-title">
                    {{ __('Danh sách banner') }}
                </h3>
            </div>
            @canAny(['banners.store'])
            <div class="k-portlet__head-toolbar">
                <div class="k-portlet__head-toolbar-wrapper">
                    @can('banners.store')
                    <a href="{{ route('bo.web.banners.create') }}" class="btn btn-brand btn-bold btn-upper btn-font-sm">
                        <i class="la la-plus"></i>
                        {{ __('Tạo banner') }}
                    </a>
                    @endcan
                </div>
            </div>
            @endcan
        </div>
        <div class="k-portlet__body">
            <table id="table_banners_index" data-group-column="1" data-searching="true" data-request-url="{{ route('bo.api.banners.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                <thead>
                    <tr>
                        <th data-property="id" width="50">{{ __('ID') }}</th>
                        <th data-orderable="false" data-badge data-name="type" data-property="type_name">{{ __('Loại') }}</th>
                        <th data-orderable="false" data-property="desktop_image" data-render-callback="renderCallbackImage">{{ __('Ảnh Desktop') }}</th>
                        <th data-orderable="false" data-property="mobile_image" data-render-callback="renderCallbackImage">{{ __('Ảnh Mobile') }}</th>
                        <th data-property="name">{{ __('Tên') }}</th>
                        <th data-property="cta_label" width="80">{{ __('Nhãn CTA') }}</th>
                        <th data-property="redirect_url">{{ __('URL') }}</th>
                        <th data-property="order" width="50">{{ __('Thứ tự') }}</th>
                        <th data-orderable="false" data-badge data-name="status" data-property="status_name" width="80">{{ __('Trạng thái') }}</th>
                        <th data-orderable="false" data-property="color" data-render-callback="renderCallbackColor" width="80">{{ __('Màu sắc') }}</th>
                        <th data-property="start_at" width="150">{{ __('Ngày bắt đầu') }}</th>
                        <th data-property="end_at" width="150">{{ __('Ngày kết thúc') }}</th>
                        <th data-property="created_at" width="200">{{ __('Ngày tạo') }}</th>
                        <th data-property="updated_at" width="200">{{ __('Ngày cập nhật') }}</th>
                        <th class="datatable-action" data-property="actions">{{ __('Hành động') }}</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@component('backoffice.partials.datatable') @endcomponent

@section('js_script')
<script>
    function renderCallbackImage(data, type, full) {
        const image = $('<img>', {
            src: data,
            width: 80,
            height: 80,
        });

        return image.prop('outerHTML');
    }

    function renderCallbackColor(data) {
        let div = $('<div class="d-flex align-items-center flex-column justify-content-center">');

        div = div.append(`<div style="background: ${data}!important; width: 40px; height: 40px;"></div>`);
        div = div.append(`<span class="mt-2">${data}</span>`);

        return div.prop('outerHTML');
    }

    onDelete();

    function onDelete() {
        $(document).on('click', '[data-action=delete]', function(e) {
            e.preventDefault();

            let confirmation = confirm("{{ __('Bạn có chắc chắn muốn xóa?') }}");

            if (! confirmation) {
                return;
            }

            $.ajax({
                url: $(this).attr('href'),
                method: 'delete',
                preventRedirectOnComplete: 1,
                success: function(res) {
                    $('#table_banners_index').DataTable().ajax.reload();
                }
            });
        });
    }
</script>
@endsection
