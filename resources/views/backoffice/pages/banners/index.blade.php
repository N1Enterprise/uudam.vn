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
                    {{ __('Banner') }}
                </h3>
            </div>
            @canAny(['banners.store'])
            <div class="k-portlet__head-toolbar">
                <div class="k-portlet__head-toolbar-wrapper">
                    @can('banners.store')
                    <a href="{{ route('bo.web.banners.create') }}" class="btn btn-brand btn-bold btn-upper btn-font-sm">
                        <i class="la la-plus"></i>
                        {{ __('Create Banner') }}
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
                        <th data-property="id">{{ __('ID') }}</th>
                        <th data-orderable="false" data-badge data-name="type" data-property="type_name">{{ __('Type') }}</th>
                        <th data-property="name">{{ __('Tên') }}</th>
                        <th data-property="cta_label">{{ __('Cta Label') }}</th>
                        <th data-property="redirect_url">{{ __('url') }}</th>
                        <th data-property="order">{{ __('Order') }}</th>
                        <th data-orderable="false" data-badge data-name="status" data-property="status_name">{{ __('Trạng thái') }}</th>
                        <th data-property="start_at">{{ __('Start At') }}</th>
                        <th data-orderable="false" data-property="color" data-render-callback="renderCallbackColor">{{ __('Color') }}</th>
                        <th data-property="end_at">{{ __('End At') }}</th>
                        <th data-property="created_at">{{ __('Ngày tạo') }}</th>
                        <th data-property="updated_at">{{ __('Ngày cập nhật') }}</th>
                        <th data-orderable="false" data-property="desktop_image" data-render-callback="renderCallbackImage">{{ __('Desktop Image') }}</th>
                        <th data-orderable="false" data-property="mobile_image" data-render-callback="renderCallbackImage">{{ __('Mobile Image') }}</th>
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

            let confirmation = confirm("{{ __('Are you sure you want to delete this banner?') }}");

            if(! confirmation) {
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
