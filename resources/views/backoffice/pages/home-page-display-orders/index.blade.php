@extends('backoffice.layouts.master')

@php
	$title = __('Nhóm hiển thị trang chủ');

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
                        {{ __('Danh sách nhóm hiển thị') }}
                    </h3>
                </div>
                <div class="k-portlet__head-toolbar">
                    <div class="k-portlet__head-toolbar-wrapper">
                        @can('home-page-display-orders.store')
                        <a href="{{ route('bo.web.home-page-display-orders.create') }}" class="btn btn-brand btn-bold btn-upper btn-font-sm">
                            <i class="la la-plus"></i>
                            {{ __('Tạo nhóm hiển thị trang chủ') }}
                        </a>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="k-portlet__body">
                <table id="table_home_page_display_order" data-searching="true" data-request-url="{{ route('bo.api.home-page-display-orders.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                    <thead>
                        <tr>
                            <th data-property="id">{{ __('ID') }}</th>
                            <th data-property="name">{{ __('Tên') }}</th>
                            <th data-property="order">{{ __('Thứ tự') }}</th>
                            <th data-orderable="false" data-badge data-name="status" data-property="status_name">{{ __('Trạng thái') }}</th>
                            <th data-orderable="false" data-badge data-name="display_on_frontend" data-property="display_on_frontend_name">{{ __('Hiển thị FE') }}</th>
                            <th data-property="created_at">{{ __('Ngày tạo') }}</th>
                            <th data-property="updated_at">{{ __('Ngày cập nhật') }}</th>
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
    onDelete();

    function onDelete() {
        $(document).on('click', '[data-action=delete]', function(e) {
            e.preventDefault();

            let confirmation = confirm("{{ __('Bạn có chắc chắn muốn xóa hiển thị trang chủ này không?') }}");

            if (! confirmation) {
                return;
            }

            $.ajax({
                url: $(this).attr('href'),
                method: 'delete',
                preventRedirectOnComplete: 1,
                success: function(res) {
                    $('#table_home_page_display_order').DataTable().ajax.reload();
                }
            });
        });
    }
</script>
@endsection
