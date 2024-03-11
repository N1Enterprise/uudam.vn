@extends('backoffice.layouts.master')

@php
	$title = __('Trang');

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
        @include('backoffice.partials.message')
        <div class="k-portlet k-portlet--mobile">
            <div class="k-portlet__head">
                <div class="k-portlet__head-label">
                    <h3 class="k-portlet__head-title">
                        {{ __('Danh sách trang') }}
                    </h3>
                </div>
                @canAny(['pages.store'])
                <div class="k-portlet__head-toolbar">
                    <div class="k-portlet__head-toolbar-wrapper">
                        @can('pages.store')
                        <a href="{{ route('bo.web.pages.create') }}" class="btn btn-brand btn-bold btn-upper btn-font-sm">
                            <i class="la la-plus"></i>
                            {{ __('Tạo trang') }}
                        </a>
                        @endcan
                    </div>
                </div>
                @endcan
            </div>
            <div class="k-portlet__body">
                <table id="table_pages_index" data-searching="true" data-request-url="{{ route('bo.api.pages.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                    <thead>
                        <tr>
                            <th data-property="id">{{ __('ID') }}</th>
                            <th data-property="name">{{ __('Tên') }}</th>
                            <th data-property="slug">{{ __('Đường dẫn') }}</th>
                            <th data-property="title">{{ __('Tiêu đề') }}</th>
                            <th data-property="order">{{ __('Thứ tự') }}</th>
                            <th data-property="display_in" data-render-callback="renderDisplayInCallback">{{ __('Hiển thị tại') }}</th>
                            <th data-orderable="false" data-badge data-name="status" data-property="status_name">{{ __('Trạng thái') }}</th>
                            <th data-orderable="false" data-badge data-name="display_on_frontend" data-property="display_on_frontend_name">{{ __('Hiển thị FE') }}</th>
                            <th data-orderable="false" data-property="created_by.name">{{ __('Người tạo') }}</th>
                            <th data-orderable="false" data-property="updated_by.name">{{ __('Người cập nhật') }}</th>
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
    onSeeMoreDisplayIn();

    function renderDisplayInCallback(data, type, full) {
        const displayInList = data || [];

        const count = displayInList?.length || 0;

        if (! count) {
            return;
        }

        const displayInsBadge = displayInList.map((displayin, index) => {
            return $('<span>', { class: `mr-1 mt-1 display-in-item ${count >= 25 && index >= 25 ? 'd-none' : 'd-inline-block'}` })
                    .append(`<span class="k-badge k-badge--brand k-badge--inline k-badge--outline k-badge--pill">${displayin}</span>`).prop('outerHTML');
        });

        const container = $('<div>', { class: 'display-in-see-more' }).append(displayInsBadge.join(''));

        if (count >= 25) {
            container.append('<button type="button" class="btn btn-link p-1 see-more-button" style="font-size: 0.8rem;">More</button>');
        }
        return container.prop('outerHTML');
    }

    function onSeeMoreDisplayIn() {
        $(document).on('click', '.display-in-see-more .see-more-button', function() {
            const isOpen = $(this).hasClass('is-open');
            $(this).text(isOpen ? 'More' : 'Less');
            $(this).toggleClass('is-open', !isOpen);
            if (isOpen) {
                $(this).parents('.display-in-see-more').find('.display-in-item:gt(24)').removeClass('d-inline-block');
                $(this).parents('.display-in-see-more').find('.display-in-item:gt(24)').addClass('d-none');
            } else {
                $(this).parents('.display-in-see-more').find('.display-in-item').removeClass('d-none');
                $(this).parents('.display-in-see-more').find('.display-in-item').addClass('d-inline-block');
            }
        });
    }
</script>
@endsection
